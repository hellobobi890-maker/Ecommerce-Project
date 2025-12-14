<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    /**
     * Display the shop page with filters and sorting.
     */
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        
        $query = Product::where('is_active', true);

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Price Range Filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Stock Filter
        if ($request->has('in_stock')) {
            $query->where('stock', '>', 0);
        }

        // Build filter options from the current base query (category/price/stock applied)
        $filterQuery = clone $query;

        // Color Filter
        if ($request->filled('color')) {
            $query->whereJsonContains('color_options', $request->color);
        }

        // Size Filter
        if ($request->filled('size')) {
            $query->whereJsonContains('sizes', $request->size);
        }

        // Sorting
        $sortBy = $request->input('sort', 'newest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'popular':
                $query->withCount('approvedReviews')->orderBy('approved_reviews_count', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $products = $query->with('category')->paginate(12)->withQueryString();

        // Get all available sizes and colors for filter options with counts
        $allProducts = $filterQuery->get();
        $colorData = [];
        $sizeData = [];
        
        foreach ($allProducts as $p) {
            if (is_array($p->color_options)) {
                foreach ($p->color_options as $color) {
                    if (!isset($colorData[$color])) {
                        $colorData[$color] = ['count' => 0, 'in_stock' => 0];
                    }
                    $colorData[$color]['count']++;
                    if ($p->stock > 0) {
                        $colorData[$color]['in_stock']++;
                    }
                }
            }
            if (is_array($p->sizes)) {
                foreach ($p->sizes as $size) {
                    if (!isset($sizeData[$size])) {
                        $sizeData[$size] = ['count' => 0, 'in_stock' => 0];
                    }
                    $sizeData[$size]['count']++;
                    if ($p->stock > 0) {
                        $sizeData[$size]['in_stock']++;
                    }
                }
            }
        }
        
        $availableColors = array_keys($colorData);
        $availableSizes = array_keys($sizeData);

        return view('shop.index', compact(
            'categories', 
            'products', 
            'availableColors', 
            'availableSizes',
            'colorData',
            'sizeData'
        ));
    }

    /**
     * Display the specified product.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'approvedReviews.user', 'variants'])
            ->firstOrFail();
            
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        // Check if user has already reviewed
        $userReview = null;
        if (auth()->check()) {
            $userReview = $product->reviews()->where('user_id', auth()->id())->first();
        }

        return view('shop.show', compact('product', 'relatedProducts', 'userReview'));
    }
}

