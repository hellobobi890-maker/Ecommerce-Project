<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        $cart = Session::get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', compact('cart'));
    }

    /**
     * Place an order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'phone' => 'required',
        ]);

        $cart = Session::get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            // Calculate total details
            $totalAmount = 0;
            foreach ($cart as $id => $details) {
                $totalAmount += $details['price'] * $details['quantity'];
            }
            // Add fixed shipping for now
            $totalAmount += 5;

            // Create Order
            $order = Order::create([
                'user_id' => auth()->id() ?? null, // Nullable if guest checkout allowed, though we force auth usually.
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'shipping_address' => $request->address . ', ' . $request->city . ', ' . $request->postal_code,
                'payment_method' => 'cod', // Hardcoded to COD for now as per plan logic? Or we add payment integration later.
                'payment_status' => 'pending',
            ]);

            // Create Order Items
            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            DB::commit();
            Session::forget('cart');

            return redirect()->route('home')->with('success', 'Order placed successfully! Your Order ID is ' . $order->order_number);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong while placing order.');
        }
    }
}
