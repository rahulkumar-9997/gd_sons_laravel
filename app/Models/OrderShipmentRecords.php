<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShipmentRecords extends Model
{
    use HasFactory;
    protected $table = 'order_shipment_records';
    protected $fillable = [
        'id',
        'order_id',
        'order_status_id',
        'customer_id',
        'tracking_no',
        'courier_name',
        'shipment_details',
        'shipment_date',
        'receiving_date',
    ];
}
