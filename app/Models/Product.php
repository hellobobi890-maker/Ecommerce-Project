<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
