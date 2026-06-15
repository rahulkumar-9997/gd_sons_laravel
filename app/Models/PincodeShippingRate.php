<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PincodeShippingRate extends Model
{
    use HasFactory;
    protected $fillable = [
        'pincode_id',
        'weight_category_id',
        'shipping_rate',
    ];

    public function pincode()
    {
        return $this->belongsTo(Pincode::class);
    }

    public function weightCategory()
    {
        return $this->belongsTo(WeightCategory::class);
    }
}
