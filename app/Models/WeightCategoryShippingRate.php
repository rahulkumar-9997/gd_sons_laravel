<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeightCategoryShippingRate extends Model
{
    use HasFactory;
    protected $table = 'weight_category_shipping_rates';
    protected $fillable = [
        'weight_category_id',
        'rate',
    ];

    public function weightCategory()
    {
        return $this->belongsTo(WeightCategory::class);
    }

}
