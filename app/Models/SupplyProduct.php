<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SupplyProduct extends Pivot
{
    protected $table = 'supply_products';
    public $incrementing = true;
    protected $fillable = [
        'supply_id',
        'product_id',
        'qty',
        'unit',
        'sort_order',
    ];

    public function supply()
    {
        return $this->belongsTo(Supply::class, 'supply_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}