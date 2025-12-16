<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Coupon;

class CheckoutController extends Controller
{
    private int $shippingFee = 200;

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
     * Display the checkout page.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $coupon = Session::get('applied_coupon');

        if (count($cart) == 0) {
            return redirect()->route('shop.index')->with('error', 'Aap ka cart khali hai.');
        }

        // Calculate totals
        $subtotal = $this->cartSubtotal($cart);
        $coupon = $this->refreshAppliedCoupon($subtotal);
        $discount = $coupon ? (float) ($coupon['discount_amount'] ?? 0) : 0;
        $shipping = $this->shippingFee; // PKR shipping
        $total = max(0, $subtotal - $discount) + $shipping;

        return view('checkout.index', compact('cart', 'coupon', 'subtotal', 'discount', 'shipping', 'total'));
    }

    /**
     * Place an order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'phone' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $cart = Session::get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('shop.index')->with('error', 'Aap ka cart khali hai.');
        }

        DB::beginTransaction();

        try {
            // Verify stock for all items first
            foreach ($cart as $key => $details) {
                $product = Product::find($details['product_id']);
                if (!$product) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "'{$details['name']}' ka stock available nahi hai.");
                }

                $qty = (int) ($details['quantity'] ?? 0);
                if ($qty < 1) {
                    $qty = 1;
                }

                $variantId = $details['product_variant_id'] ?? null;
                if ($variantId) {
                    $variant = ProductVariant::find($variantId);
                    if (!$variant || (int) $variant->stock < $qty) {
                        DB::rollBack();
                        return redirect()->back()->with('error', "'{$details['name']}' ka stock available nahi hai.");
                    }
                } elseif ($product->variants()->exists()) {
                    $variant = $product->getVariantBySelection($details['color'] ?? null, $details['size'] ?? null);
                    if (!$variant || (int) $variant->stock < $qty) {
                        DB::rollBack();
                        return redirect()->back()->with('error', "'{$details['name']}' ka stock available nahi hai.");
                    }
                } else {
                    if ((int) $product->stock < $qty) {
                        DB::rollBack();
                        return redirect()->back()->with('error', "'{$details['name']}' ka stock available nahi hai.");
                    }
                }
            }

            // Calculate totals
            $subtotal = $this->cartSubtotal($cart);
            $coupon = $this->refreshAppliedCoupon($subtotal);
            $discount = $coupon ? (float) ($coupon['discount_amount'] ?? 0) : 0;
            $shipping = $this->shippingFee; // PKR shipping
            $totalAmount = max(0, $subtotal - $discount) + $shipping;

            // Create Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'full_name' => $request->input('full_name'),
                'email' => $request->input('email'),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'shipping_address' => $request->address . ', ' . $request->city . ', ' . $request->postal_code,
                'phone' => $request->phone,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'notes' => $request->notes,
            ]);

            // Create Order Items and decrement stock
            foreach ($cart as $key => $details) {
                $product = Product::find($details['product_id']);

                $qty = (int) ($details['quantity'] ?? 0);
                if ($qty < 1) {
                    $qty = 1;
                }

                $variantId = $details['product_variant_id'] ?? null;
                $variant = null;
                if ($variantId) {
                    $variant = ProductVariant::find($variantId);
                } elseif ($product && $product->variants()->exists()) {
                    $variant = $product->getVariantBySelection($details['color'] ?? null, $details['size'] ?? null);
                    $variantId = $variant?->id;
                }
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $details['product_id'],
                    'product_variant_id' => $variantId,
                    'quantity' => $qty,
                    'price' => $details['price'],
                    'size' => $details['size'] ?? null,
                    'color' => $details['color'] ?? null,
                ]);

                // Decrement stock
                if ($product) {
                    if ($variant) {
                        $product->decrementVariantStock($variant, $qty);
                    } else {
                        $product->decrementStock($qty);
                    }
                }
            }

            // Update coupon usage if applied
            if ($coupon) {
                $couponModel = Coupon::find($coupon['id']);
                if ($couponModel) {
                    $couponModel->increment('used_count');
                }
            }

            DB::commit();
            
            // Clear cart and coupon
            Session::forget('cart');
            Session::forget('applied_coupon');

            return redirect()->route('orders.show', $order->order_number)
                ->with('success', 'Order place ho gaya! Order ID: ' . $order->order_number);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Order place karte waqt error aa gaya. Dobara try karein.');
        }
    }
}

