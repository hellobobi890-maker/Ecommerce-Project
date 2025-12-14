<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    /**
     * Apply coupon to cart
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', strtoupper($request->code))->first();

        if (!$coupon) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid coupon code!'
                ], 400);
            }
            return redirect()->back()->with('error', 'Invalid coupon code!');
        }

        // Calculate cart total
        $cart = Session::get('cart', []);
        $cartTotal = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

        if (!$coupon->isValid($cartTotal)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Yeh coupon valid nahi hai ya minimum order requirement poori nahi hui.'
                ], 400);
            }
            return redirect()->back()->with('error', 'Yeh coupon valid nahi hai ya minimum order requirement poori nahi hui.');
        }

        // Store coupon in session
        Session::put('applied_coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount_type' => $coupon->discount_type,
            'discount_value' => $coupon->discount_value,
            'discount_amount' => $coupon->calculateDiscount($cartTotal),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Coupon apply ho gaya!',
                'discount' => $coupon->calculateDiscount($cartTotal),
            ]);
        }

        return redirect()->back()->with('success', 'Coupon apply ho gaya!');
    }

    /**
     * Remove applied coupon
     */
    public function remove(Request $request)
    {
        Session::forget('applied_coupon');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Coupon remove ho gaya.'
            ]);
        }

        return redirect()->back()->with('success', 'Coupon remove ho gaya.');
    }
}
