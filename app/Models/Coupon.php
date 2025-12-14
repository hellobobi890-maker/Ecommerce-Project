<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_uses',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    /**
     * Check if coupon is valid
     */
    public function isValid(float $orderAmount = 0): bool
    {
        // Check if active
        if (!$this->is_active) {
            return false;
        }

        // Check dates
        $now = now();
        if ($this->valid_from && $now->lt($this->valid_from)) {
            return false;
        }
        if ($this->valid_until && $now->gt($this->valid_until)) {
            return false;
        }

        // Check usage limit
        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }

        // Check minimum order amount
        if ($this->min_order_amount && $orderAmount < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount(float $orderAmount): float
    {
        if ($this->discount_type === 'percentage') {
            return $orderAmount * ($this->discount_value / 100);
        }

        return min($this->discount_value, $orderAmount);
    }
}
