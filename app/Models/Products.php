<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\ProductFactory::new();
    }

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'description',
        'price',
        'is_trending',
        'is_available',
        'amount',
        'discount',
        'image',
    ];

    protected $casts = [
        'is_trending' => 'boolean',
        'is_available' => 'boolean',
        'price' => 'decimal:2',
        'discount' => 'double',
        'amount' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Catgories::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }
}
