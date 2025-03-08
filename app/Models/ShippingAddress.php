<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;
    protected $table = 'shipping_addresses';
    protected $fillable = [
        'id',
        'customer_id',
        'full_name',
        'phone_number',
        'email_id',
        'country',
        'full_address',
        'apartment',
        'city_name',
        'state',
        'pin_code',
    ];
}
