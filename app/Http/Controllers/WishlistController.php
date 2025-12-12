<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->with('product')->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to add to wishlist');
        }

        Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Added to wishlist']);
        }

        return back()->with('success', 'Added to wishlist');
    }

    public function destroy($id)
    {
        Wishlist::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Product removed from wishlist');
    }
}
