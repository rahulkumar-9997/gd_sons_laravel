<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributesValues extends Model
{
    use HasFactory;
    protected $table = 'product_attributes_values';
    protected $fillable = [
        'id',
        'product_id',
        'product_attribute_id',
        'attributes_value_id',
        'sort_order',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttributes::class, 'product_attribute_id');
    }

    public function attributeValue()
    {
        return $this->belongsTo(Attribute_values::class, 'attributes_value_id');
    }
}
