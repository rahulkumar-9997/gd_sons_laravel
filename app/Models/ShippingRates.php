<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRates extends Model
{
    protected $table = 'pincode_data';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pincode',
        'post_office',
        'weight_450gm',
        'weight_750gm',
        'weight_1350gm',
        'weight_3400gm',
        'weight_7500gm',
        'weight_14kg',
        'weight_25kg',
    ];
    public $timestamps = true;
    protected $casts = [
        'weight_450gm' => 'integer',
        'weight_750gm' => 'integer',
        'weight_1350gm' => 'integer',
        'weight_3400gm' => 'integer',
        'weight_7500gm' => 'integer',
        'weight_14kg' => 'integer',
        'weight_25kg' => 'integer',
    ];
}