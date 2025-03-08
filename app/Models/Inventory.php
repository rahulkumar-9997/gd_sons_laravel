<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventories';
    protected $fillable = [
        'id',
        'product_id',
        'mrp',
        'purchase_rate',
        'offer_rate',
        'stock_quantity',
        'sku'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    // public function vendorPurchaseLines()
    // {
    //     return $this->hasMany(VendorPurchaseLine::class, 'inventory_id');
    // }
}
