<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'category',
        'image',
        'original_price',
        'sale_price',
        'discount_percent',
        'is_best_seller',
        'sold_count'
    ];

    /**
     * Get display price (sale price if available, otherwise regular price)
     */
    public function getDisplayPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Check if product has sale
     */
    public function getHasSaleAttribute()
    {
        return !is_null($this->sale_price) && $this->discount_percent > 0;
    }
}
