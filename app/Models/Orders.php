<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'id',
        'order_date',
        'order_id',
        'grand_total_amount',
        'payment_mode',
        'payment_received',
        'pick_up_status',
        'customer_id',
        'shipping_address_id',
        'billing_address_id',
        'billing_address_id',
        'order_status_id',
        'razorpay_payment_id',
        'razorpay_signature_id',
        'razorpay_order_id',
        'razorpay_method',
        'payment_status',
        'failure_reason'
    ];

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(BillingAddress::class, 'billing_address_id');
    }

    public function orderLines()
    {
        return $this->hasMany(OrderLines::class, 'order_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    public function shiprocketCourier()
    {
        return $this->hasOne(ShiprocketCourier::class, 'order_id', 'id');
    }

    public function shiprocketOrderResponse()
    {
        return $this->hasOne(ShiprocketOrderResponse::class, 'order_id', 'id');
    }

}
