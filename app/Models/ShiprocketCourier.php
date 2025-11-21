<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiprocketCourier extends Model
{
    use HasFactory;
    protected $table = 'shiprocket_couriers';
    protected $fillable = [
        'customer_id',
        'order_id',
        'courier_name',
        'courier_id',
        'courier_company_id',
        'courier_shipping_rate',
        'cod_charges',
        'delivery_expected_date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
