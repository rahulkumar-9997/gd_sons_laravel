<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiprocketPickupResponse extends Model
{
    use HasFactory;
    protected $table = 'shiprocket_pickup_response';
    protected $fillable = [
        'order_id',
        'pickup_status',
        'pickup_scheduled_date',
        'pickup_token_number',
        'status',
        'others',
        'pickup_generated_date',
        'data'
    ];

    protected $casts = [
        'others' => 'array',
        'pickup_generated_date' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }
}
