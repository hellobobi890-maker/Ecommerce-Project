<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the cart page.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    /**
     * Add a product to the cart.
     */
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image, // Assuming product has an image attribute or we use placeholder
                "product_id" => $product->id
            ];
        }

        Session::put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => count($cart)
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
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
        }

        return redirect()->back()->with('success', 'Product removed from cart successfully!');
    }
}
