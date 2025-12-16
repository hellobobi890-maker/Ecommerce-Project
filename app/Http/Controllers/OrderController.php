<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Show user's order history
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show($orderNumber)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('order_number', $orderNumber)
            ->with(['items.product'])
            ->firstOrFail();

        $productIds = $order->items->pluck('product_id')->filter()->unique()->values();
        $reviewedProductIds = Review::where('user_id', auth()->id())
            ->whereIn('product_id', $productIds)
            ->pluck('product_id')
            ->all();

        return view('orders.show', compact('order', 'reviewedProductIds'));
    }

    public function reorder($orderNumber)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('order_number', $orderNumber)
            ->with(['items.product'])
            ->firstOrFail();

        if ($order->status !== 'delivered') {
            return redirect()->back()->with('error', 'Re-order sirf delivered order ke liye available hai.');
        }

        $cart = Session::get('cart', []);

        $addedAny = false;
        $limitedAny = false;
        $skippedAny = false;

        foreach ($order->items as $item) {
            $productId = $item->product_id;
            if (!$productId) {
                $skippedAny = true;
                continue;
            }

            $product = Product::find($productId);
            if (!$product) {
                $skippedAny = true;
                continue;
            }

            $qty = (int) ($item->quantity ?? 1);
            if ($qty < 1) {
                $qty = 1;
            }

            $size = $item->size;
            $color = $item->color;
            $variantId = $item->product_variant_id;

            $availableStock = (int) ($product->stock ?? 0);
            if ($variantId) {
                $variant = ProductVariant::find($variantId);
                $availableStock = $variant ? (int) $variant->stock : 0;
            } elseif ($product->variants()->exists()) {
                $variant = $product->getVariantBySelection($color, $size);
                $variantId = $variant?->id;
                $availableStock = $variant ? (int) $variant->stock : 0;
            }

            if ($availableStock <= 0) {
                $skippedAny = true;
                continue;
            }

            $sizeKey = $size ?? 'default';
            $colorKey = $color ?? 'default';
            $cartKey = $product->id . '_' . $sizeKey . '_' . $colorKey;

            $existingQty = isset($cart[$cartKey]) ? (int) ($cart[$cartKey]['quantity'] ?? 0) : 0;
            $targetQty = $existingQty + $qty;
            if ($targetQty > $availableStock) {
                $targetQty = $availableStock;
                $limitedAny = true;
            }

            if ($targetQty <= 0) {
                $skippedAny = true;
                continue;
            }

            $cart[$cartKey] = [
                'name' => $product->name,
                'quantity' => $targetQty,
                'price' => $product->sale_price ?? $product->price,
                'image' => is_array($product->images) && count($product->images) > 0
                    ? $product->images[0]
                    : 'https://placehold.co/100x100?text=Product',
                'product_id' => $product->id,
                'product_variant_id' => $variantId,
                'size' => $size,
                'color' => $color,
                'slug' => $product->slug,
            ];

            $addedAny = true;
        }

        Session::put('cart', $cart);

        if (!$addedAny) {
            return redirect()->route('cart.index')->with('error', 'Re-order ke liye koi item available nahi tha.');
        }

        if ($skippedAny || $limitedAny) {
            return redirect()->route('cart.index')->with('success', 'Cart update ho gaya. Kuch items out of stock thay ya quantity limited hui.');
        }

        return redirect()->route('cart.index')->with('success', 'Re-order ke items cart mein add ho gaye!');
    }
}
