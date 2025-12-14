<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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

        return view('orders.show', compact('order'));
    }
}
