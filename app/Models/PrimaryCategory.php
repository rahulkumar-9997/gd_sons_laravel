<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryCategory extends Model
{
    use HasFactory;
    protected $table = 'primary_categories';
    protected $fillable = [
        'title',
        'image_path',
        'link',
        'primary_category_description',
        'status',
        'product_id'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'primary_category_products');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];
}
