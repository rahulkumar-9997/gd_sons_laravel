<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'wishlists';
    protected $fillable = [
        'id',
        'customer_id',
        'product_id',
        'created_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
