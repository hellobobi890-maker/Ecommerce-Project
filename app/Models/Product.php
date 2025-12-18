<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'sku',
        'stock',
        'images',
        'is_featured',
        'is_trending',
        'badge_text',
        'color_options',
        'sizes',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'color_options' => 'array',
        'sizes' => 'array',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    /**
     * Get images with proper asset URLs
     * Uses ASSET_PREFIX env variable: empty for localhost, '/public' for shared hosting
     */
    public function getImagesAttribute($value): array
    {
        $images = is_string($value) ? json_decode($value, true) : $value;

        if (!is_array($images) || empty($images)) {
            return [];
        }

        // Get prefix from env - empty for localhost, '/public' for live
        $prefix = rtrim(env('ASSET_PREFIX', ''), '/');

        return array_map(function ($img) use ($prefix) {
            if (empty($img)) {
                return $img;
            }
            // Already a full URL
            if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://') || str_starts_with($img, '//')) {
                return $img;
            }
            // Already has /public prefix
            if (str_starts_with($img, '/public/')) {
                return $img;
            }
            // For /storage/ paths, add prefix
            if (str_starts_with($img, '/storage/') || str_starts_with($img, 'storage/')) {
                $path = '/' . ltrim($img, '/');
                return $prefix . $path;
            }
            // For other relative paths
            $path = '/' . ltrim($img, '/');
            return $prefix . $path;
        }, $images);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get approved reviews only
     */
    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    /**
     * Get average rating
     */
    public function getAverageRatingAttribute(): float
    {
        return round($this->approvedReviews()->avg('rating') ?? 0, 1);
    }

    /**
     * Get reviews count
     */
    public function getReviewsCountAttribute(): int
    {
        return $this->approvedReviews()->count();
    }

    /**
     * Check if product is in stock
     */
    public function isInStock(): bool
    {
        if ($this->relationLoaded('variants') ? $this->variants->isNotEmpty() : $this->variants()->exists()) {
            return ($this->relationLoaded('variants') ? $this->variants : $this->variants()->get())
                ->contains(fn($v) => (int) $v->stock > 0);
        }

        return $this->stock > 0;
    }

    public function makeVariantKey(?string $color, ?string $size): string
    {
        $c = trim((string) $color);
        $s = trim((string) $size);

        $c = $c === '' ? '-' : mb_strtolower($c);
        $s = $s === '' ? '-' : mb_strtolower($s);

        return $c . '|' . $s;
    }

    public function getVariantBySelection(?string $color, ?string $size): ?ProductVariant
    {
        $key = $this->makeVariantKey($color, $size);

        if ($this->relationLoaded('variants')) {
            return $this->variants->firstWhere('variant_key', $key);
        }

        return $this->variants()->where('variant_key', $key)->first();
    }

    /**
     * Decrement stock after order
     */
    public function decrementStock(int $quantity = 1): bool
    {
        if ($this->stock >= $quantity) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    public function decrementVariantStock(ProductVariant $variant, int $quantity = 1): bool
    {
        if ($variant->stock < $quantity) {
            return false;
        }

        $variant->decrement('stock', $quantity);

        if ($this->stock >= $quantity) {
            $this->decrement('stock', $quantity);
        }

        return true;
    }
}
