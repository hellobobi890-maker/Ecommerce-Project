<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('orders'));
    }
}
