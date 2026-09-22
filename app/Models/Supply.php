<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Supply extends Model
{
    use HasFactory;
    protected $table = 'supplies';
    protected $fillable = [
        'title',
        'buyer',
        'place',
        'sort_order',
        'status',
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'supply_products', 'supply_id', 'product_id')
            ->withPivot('qty', 'unit', 'sort_order')
            ->withTimestamps();
    }
}