<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';
    protected $fillable = [
        'id',
        'name',
        'phone_number',
        'country',
        'address',
        'apartment',
        'city',
        'state',
        'zip_code',
        'customer_id',
    ];
}
