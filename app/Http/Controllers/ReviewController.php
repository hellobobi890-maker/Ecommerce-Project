<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a new review
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $hasDeliveredPurchase = Order::where('user_id', auth()->id())
            ->where('status', 'delivered')
            ->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })
            ->exists();

        if (!$hasDeliveredPurchase) {
            return redirect()->back()->with('error', 'Review sirf delivered order ke baad submit ho sakta hai.');
        }

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Aap is product ko pehle review kar chuke hain.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Review submit ho gaya hai. Shukriya!');
    }

    /**
     * Delete a review (user can delete their own review)
     */
    public function destroy($id)
    {
        $review = Review::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $review->delete();

        return redirect()->back()->with('success', 'Review delete ho gaya.');
    }
}
