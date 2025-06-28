<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute_values extends Model
{
    use HasFactory;
    protected $table = 'attributes_value';
    protected $fillable = [
        'id',
        'name',
        'slug',
        'attributes_id',
        'sort_order',
        'images'
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

    /**this code find mapattributes to category relationship */
    public function map_attributes_value_to_categories()
    {
        return $this->belongsToMany(Category::class, 'map_attributes_values_to_category', 'attributes_value_id', 'category_id');
    }

    /**check attributes_value name where - where mapped this table  MapAttributesValueToCategory, ProductAttributesValues*/
    public function mappedCategories()
    {
        return $this->hasMany(MapAttributesValueToCategory::class, 'attributes_value_id');
    }

    public function productAttributesValues()
    {
        return $this->hasMany(ProductAttributesValues::class, 'attributes_value_id');
    }
    /**check attributes_value name where - where mapped this table  */
    public function hsnGst()
    {
        return $this->hasOne(UpdateHsnGstWithAttributes::class, 'attributes_value_id');
    }
    // public function products()
    // {
    //     return $this->belongsToMany(Product::class, 'product_attributes_values', 'attributes_value_id', 'product_id')
    //         ->withPivot('attribute_id');
    // }

}
