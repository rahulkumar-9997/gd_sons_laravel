<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;
    protected $table = 'discount_codes';
    protected $fillable = [
        'discount_code',
        'mode',
        'discount_value',
        'valid_from',
        'valid_till',
        'short_description',
        'minimum_order_value',
        'maximum_discount',
        'is_active',
    ];
    protected $casts = [
        'valid_from' => 'date',
        'valid_till' => 'date',
        'is_active'  => 'boolean',
    ];
}
