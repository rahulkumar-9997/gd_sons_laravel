<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateHsnGstWithAttributes extends Model
{
    use HasFactory;
    protected $table = 'update_hsn_gst_with_attributes';
    protected $fillable = [
        'id',
        'category_id',
        'attributes_id',
        'attributes_value_id',
        'hsn_code',
        'gst_in_per',
        'created_at',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attributes_id', 'id');
    }
}

