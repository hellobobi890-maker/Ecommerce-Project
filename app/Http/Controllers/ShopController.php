<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    /**
     * Display the shop page.
     */
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        $products = Product::where('is_active', true)->paginate(12);

        return view('shop.index', compact('categories', 'products'));
    }

    /**
     * Display the specified product.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }
}
