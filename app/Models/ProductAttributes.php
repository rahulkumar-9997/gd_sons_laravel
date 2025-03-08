<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductAttributesValues;
class ProductAttributes extends Model
{
    use HasFactory;
    protected $table = 'product_attributes';
    protected $fillable = [
        'id',
        'product_id',
        'attributes_id',
        'sort_order',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attributes_id');
    }

    public function values()
    {
        return $this->hasMany(ProductAttributesValues::class, 'product_attribute_id');
    }

}
