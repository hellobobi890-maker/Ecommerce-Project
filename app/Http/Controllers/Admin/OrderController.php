<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with('items.product', 'user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the specified order status in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $updates = ['status' => $request->status];
        if ($request->status === 'delivered' && $order->payment_method === 'cod') {
            $updates['payment_status'] = 'paid';
        }

        $order->update($updates);

        return redirect()->route('admin.orders.index', $id)->with('success', 'Order status updated successfully!');
    }
}
