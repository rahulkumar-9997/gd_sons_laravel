<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkFeaturedProduct extends Model
{
    use HasFactory;
    protected $table = 'bulk_featured_products';
    protected $fillable = [
        'product_id',
        'bulk_rate',
        'min_qty',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'bulk_rate'  => 'decimal:2',
        'min_qty'    => 'integer',
        'sort_order' => 'integer',
        'status'     => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function scopeForFrontend($query)
    {
        return $query->where('status', 1)
        ->whereHas('product', function ($q) {
            $q->where('product_status', 1)
                ->whereHas('inventories');
        })
        ->with([
            'product:id,title,slug,brand_id',
            'product.brand',
            'product.lowestMrpInventory',
            'product.firstSortedImage',
        ])
        ->orderBy('sort_order')
        ->orderBy('id');
    }
}