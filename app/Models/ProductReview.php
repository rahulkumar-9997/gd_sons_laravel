<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    protected $table = 'product_reviews';
    protected $fillable = [
        'product_id',
        'customer_id',
        'rating_star_value',
        'review_title',
        'review_message',
        'review_name',
        'review_email',
        'status',
        'review_post_date',
    ];

    public function reviewFiles()
    {
        return $this->hasMany(ProductReviewFile::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
