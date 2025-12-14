<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search products
     */
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return redirect()->route('shop.index');
        }

        $products = Product::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('sku', 'like', "%{$query}%");
            })
            ->with('category')
            ->paginate(12);

        return view('shop.index', [
            'products' => $products,
            'searchQuery' => $query,
            'categories' => \App\Models\Category::all(),
        ]);
    }

    /**
     * AJAX search suggestions
     */
    public function suggestions(Request $request)
    {
        $query = $request->input('q');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::where('is_active', true)
            ->where('name', 'like', "%{$query}%")
            ->select('id', 'name', 'slug', 'price', 'images')
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => number_format($product->price, 2),
                    'image' => $product->images[0] ?? 'https://placehold.co/100x100?text=Product',
                    'url' => route('shop.show', $product->slug),
                ];
            });

        return response()->json($products);
    }
}
