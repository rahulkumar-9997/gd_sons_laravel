<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiprocketOrderResponse extends Model
{
    use HasFactory;
    protected $table = 'shiprocket_order_responses';
    protected $fillable = [
        'order_id',
        'shiprocket_order_id',
        'shiprocket_shipment_id',
        'shiprocket_awb_code',
        'shiprocket_label_url',
        'shiprocket_manifest_url',
        'create_order_date',
    ];
    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }
}
