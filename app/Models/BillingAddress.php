<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    use HasFactory;
    protected $table = 'billing_addresses';
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
