<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReviewFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_review_id',
        'review_file',
        'file_type'
    ];

    public function review()
    {
        return $this->belongsTo(ProductReview::class, 'product_review_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
