<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'required|string|unique:products,sku',
            'stock' => 'required|integer|min:0',
            'main_image' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
            'is_featured' => 'boolean',
            'is_trending' => 'boolean',
            'badge_text' => 'nullable|string|max:50',
            'color_options' => 'nullable|array',
            'sizes' => 'nullable|array',
            'variant_stock' => 'nullable|array',
            'use_variant_stock' => 'boolean',
            'is_active' => 'boolean',
        ]);

        unset($validated['use_variant_stock']);

        // Checkboxes
        $validated['color_options'] = $request->input('color_options', []);
        $validated['sizes'] = $request->input('sizes', []);
        $validated['slug'] = Str::slug($validated['name']);

        // Handle Image Upload (Split Logic)
        $images = [];

        // 1. Main Image (Index 0)
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('product_images', 'public');
            $images[0] = '/storage/' . $path;
        }

        // 2. Gallery Images (Append)
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('product_images', 'public');
                $images[] = '/storage/' . $path;
            }
        }

        $validated['images'] = array_values($images);

        $product = Product::create($validated);
        $this->syncVariants($product, $request);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('variants');
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'stock' => 'required|integer|min:0',
            'main_image' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
            'is_featured' => 'boolean',
            'is_trending' => 'boolean',
            'badge_text' => 'nullable|string|max:50',
            'color_options' => 'nullable|array',
            'sizes' => 'nullable|array',
            'variant_stock' => 'nullable|array',
            'use_variant_stock' => 'boolean',
            'is_active' => 'boolean',
        ]);

        unset($validated['use_variant_stock']);

        if ($request->has('name')) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Checkboxes array handling
        if ($request->has('color_options')) {
            $validated['color_options'] = $request->input('color_options', []);
        } else {
            $validated['color_options'] = null;
        }

        if ($request->has('sizes')) {
            $validated['sizes'] = $request->input('sizes', []);
        } else {
            $validated['sizes'] = null;
        }

        // Image Logic
        $currentImages = is_array($product->images) ? $product->images : [];

        // 1. Delete
        if ($request->has('delete_images')) {
            $imagesToDelete = $request->input('delete_images', []);
            $currentImages = array_filter($currentImages, function ($img) use ($imagesToDelete) {
                return !in_array($img, $imagesToDelete);
            });
        }

        // 2. Main Image (Replace Index 0)
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('product_images', 'public');
            $currentImages = array_values($currentImages); // Re-index first to safely target 0
            $currentImages[0] = '/storage/' . $path;
        }

        // 3. Gallery Append
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('product_images', 'public');
                $currentImages[] = '/storage/' . $path;
            }
        }

        $validated['images'] = array_values($currentImages);

        $product->update($validated);

        $this->syncVariants($product, $request);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    private function syncVariants(Product $product, Request $request): void
    {
        $useVariantStock = $request->boolean('use_variant_stock');
        if (!$useVariantStock) {
            if ($product->variants()->exists()) {
                $product->variants()->delete();
            }
            return;
        }

        $colors = $request->input('color_options', []);
        $sizes = $request->input('sizes', []);

        $colors = is_array($colors) ? array_values(array_filter($colors, fn($v) => $v !== null && $v !== '')) : [];
        $sizes = is_array($sizes) ? array_values(array_filter($sizes, fn($v) => $v !== null && $v !== '')) : [];

        $variantStock = $request->input('variant_stock', []);
        $variantStock = is_array($variantStock) ? $variantStock : [];

        if (count($colors) === 0 && count($sizes) === 0) {
            if ($product->variants()->exists()) {
                $product->variants()->delete();
            }
            return;
        }

        $wantedKeys = [];
        $totalStock = 0;

        $useColors = count($colors) > 0 ? $colors : [null];
        $useSizes = count($sizes) > 0 ? $sizes : [null];

        foreach ($useColors as $color) {
            foreach ($useSizes as $size) {
                $key = $product->makeVariantKey($color, $size);
                $wantedKeys[] = $key;

                $stockValue = (int) ($variantStock[$key] ?? 0);
                if ($stockValue < 0) {
                    $stockValue = 0;
                }

                ProductVariant::updateOrCreate(
                    ['product_id' => $product->id, 'variant_key' => $key],
                    ['color' => $color, 'size' => $size, 'stock' => $stockValue]
                );

                $totalStock += $stockValue;
            }
        }

        $product->variants()->whereNotIn('variant_key', $wantedKeys)->delete();

        // Update product's main stock with total variant stock
        $product->update(['stock' => $totalStock]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
