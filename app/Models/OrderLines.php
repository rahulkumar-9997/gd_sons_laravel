<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLines extends Model
{
    use HasFactory;
    protected $table = 'order_lines';
    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total_price'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
