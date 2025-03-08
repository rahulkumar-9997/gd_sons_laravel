<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsAdditionalFeature extends Model
{
    use HasFactory;
    protected $table = 'product_additional_features';
    protected $fillable = [
        'id',
        'product_id',
        'additional_feature_id',
        'product_additional_featur_value',
        'sort_order',
    ];

    public function feature(){
        return $this->belongsTo(AdditionalFeature::class, 'additional_feature_id', 'id');
    }
}
