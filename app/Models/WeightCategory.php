<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeightCategory extends Model
{
    protected $fillable = [
        'primary_weight',
        'min_weight',
        'max_weight',
    ];

    public function shippingRates()
    {
        return $this->hasMany(PincodeShippingRate::class);
    }

    public function weightCategoryShippingRate()
    {
        return $this->hasOne(WeightCategoryShippingRate::class);
    }

}
