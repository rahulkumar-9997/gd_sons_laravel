<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = [
        'id',
        'customer_id',
        'product_id',
        'quantity',
        'created_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public static function getCartDetailsWithRelations($customerId)
    {
        return self::where('customer_id', $customerId)
            ->with(['product' => function ($query) {
                $query->with(['category', 'images'])
                    ->leftJoin('inventories', function ($join) {
                        $join->on('products.id', '=', 'inventories.product_id')
                            ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                    })
                    ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.sku', 'inventories.purchase_rate');
            }])
            ->get();
    }
}
