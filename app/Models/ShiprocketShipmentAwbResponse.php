<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiprocketShipmentAwbResponse extends Model
{
    use HasFactory;
    protected $table = 'shiprocket_shipments_awb_response';
    protected $fillable = [
        'order_id',
        'shipment_id',
        'courier_company_id',
        'awb_code',
        'courier_name',
        'applied_weight',
        'company_id',
        'child_courier_name',
        'pickup_scheduled_date',
        'routing_code',
        'rto_routing_code',
        'invoice_no',
        'transporter_id',
        'transporter_name',
        'shipped_by',
    ];

    protected $casts = [
        'shipped_by' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }
}
