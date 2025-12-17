<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Coupon;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private function getShippingFee(): int
    {
        return Setting::getShippingFee();
    }

    private function cartSubtotal(array $cart): float
    {
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += (float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 1);
        }
        return (float) $subtotal;
    }

    private function refreshAppliedCoupon(float $subtotal): ?array
    {
        $couponSession = Session::get('applied_coupon');
        if (!$couponSession || empty($couponSession['id'])) {
            return null;
        }

        $couponModel = Coupon::find($couponSession['id']);
        if (!$couponModel || !$couponModel->isValid($subtotal)) {
            Session::forget('applied_coupon');
            return null;
        }

        $discountAmount = $couponModel->calculateDiscount($subtotal);
        $updated = [
            'id' => $couponModel->id,
            'code' => $couponModel->code,
            'discount_type' => $couponModel->discount_type,
            'discount_value' => $couponModel->discount_value,
            'discount_amount' => $discountAmount,
        ];

        Session::put('applied_coupon', $updated);
        return $updated;
    }

    /**
     * Display the cart page.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $subtotal = $this->cartSubtotal($cart);
        $coupon = $this->refreshAppliedCoupon($subtotal);
        return view('cart.index', compact('cart', 'coupon'));
    }

    /**
     * Add a product to the cart.
     */
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $size = $request->input('size');
        $color = $request->input('color');
        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $variantId = null;
        $availableStock = $product->stock;

        if ($product->variants()->exists()) {
            $variant = $product->getVariantBySelection($color, $size);

            if (!$variant) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please select a valid color/size.'
                    ], 400);
                }
                return redirect()->back()->with('error', 'Please select a valid color/size.');
            }

            $variantId = $variant->id;
            $availableStock = (int) $variant->stock;
        }

        if ($availableStock <= 0) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, yeh product out of stock hai!'
                ], 400);
            }
            return redirect()->back()->with('error', 'Sorry, yeh product out of stock hai!');
        }

        $cart = Session::get('cart', []);

        // Create unique key with size and color
        $sizeKey = $size ?? 'default';
        $colorKey = $color ?? 'default';
        $cartKey = $product->id . '_' . $sizeKey . '_' . $colorKey;

        $existingQty = isset($cart[$cartKey]) ? (int) $cart[$cartKey]['quantity'] : 0;
        if (($existingQty + $quantity) > $availableStock) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Sirf {$availableStock} items available hain!"
                ], 400);
            }
            return redirect()->back()->with('error', "Sirf {$availableStock} items available hain!");
        }

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->sale_price ?? $product->price,
                "image" => is_array($product->images) && count($product->images) > 0
                    ? $product->images[0]
                    : 'https://placehold.co/100x100?text=Product',
                "product_id" => $product->id,
                "product_variant_id" => $variantId,
                "size" => $size,
                "color" => $color,
                "slug" => $product->slug,
            ];
        }

        Session::put('cart', $cart);

        // Recalculate coupon (discount depends on subtotal)
        $this->refreshAppliedCoupon($this->cartSubtotal($cart));

        // Calculate total items
        $totalItems = 0;
        foreach ($cart as $item) {
            $totalItems += $item['quantity'];
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product cart mein add ho gaya!',
                'cart_count' => $totalItems
            ]);
        }

        return redirect()->back()->with('success', 'Product cart mein add ho gaya!');
    }

    /**
     * Update product quantity in cart.
     */
    public function update(Request $request, $id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $newQty = (int) $request->quantity;

            if ($newQty <= 0) {
                unset($cart[$id]);
            } else {
                // Check stock
                $product = Product::find($cart[$id]['product_id']);
                $availableStock = $product ? (int) $product->stock : 0;

                $variantId = $cart[$id]['product_variant_id'] ?? null;
                if ($variantId) {
                    $variant = ProductVariant::find($variantId);
                    $availableStock = $variant ? (int) $variant->stock : 0;
                }

                if ($product && $newQty > $availableStock) {
                    if ($request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => "Sirf {$availableStock} items available hain!"
                        ], 400);
                    }
                    return redirect()->back()->with('error', "Sirf {$availableStock} items available hain!");
                }

                $cart[$id]['quantity'] = $newQty;
            }

            Session::put('cart', $cart);
        }

        // Recalculate totals
        $subtotal = 0;
        $totalItems = 0;
        foreach ($cart as $item) {
            $subtotal += (float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 1);
            $totalItems += (int) ($item['quantity'] ?? 0);
        }

        if ($request->wantsJson()) {
            $coupon = $this->refreshAppliedCoupon((float) $subtotal);
            $discount = $coupon ? (float) ($coupon['discount_amount'] ?? 0) : 0;
            $total = max(0, (float) $subtotal - (float) $discount) + (float) $this->getShippingFee();

            return response()->json([
                'success' => true,
                'message' => 'Cart update ho gaya!',
                'cart_count' => $totalItems,
                'subtotal' => number_format($subtotal, 2),
                'discount' => number_format($discount, 2),
                'total' => number_format($total, 2),
            ]);
        }

        return redirect()->back()->with('success', 'Cart update ho gaya!');
    }

    /**
     * Remove a product from the cart.
     */
    public function destroy($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);

            // If cart is empty, remove coupon too
            if (count($cart) === 0) {
                Session::forget('applied_coupon');
            }
        }

        return redirect()->back()->with('success', 'Product cart se remove ho gaya!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        Session::forget('cart');
        Session::forget('applied_coupon');

        return redirect()->back()->with('success', 'Cart clear ho gaya!');
    }
}
