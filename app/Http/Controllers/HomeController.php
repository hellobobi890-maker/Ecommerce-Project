<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Display the home page with dynamic content.
     */
    public function index()
    {
        $categories = Category::where('is_active', true)->take(3)->get();
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->take(8)
            ->get();

        $trendingProducts = Product::where('is_active', true)
            ->where('is_trending', true)
            ->take(8) // Increased to fill rows
            ->get();

        $latestProducts = Product::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        return view('welcome', compact('categories', 'featuredProducts', 'trendingProducts', 'latestProducts'));
    }
}
