<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    protected $table = 'order_status';
    protected $fillable = [
        'id',
        'status_name',
        'description',
    ];

    public function orders()
    {
        return $this->hasMany(Orders::class, 'order_status_id');
    }
}
