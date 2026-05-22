<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalFilterAttributeValue extends Model
{
    use HasFactory;
    protected $table = 'additional_filter_attribute_values';

    protected $fillable = [
        'additional_filter_attribute_id',
        'attribute_value_id',
    ];

    
    public function filterAttribute()
    {
        return $this->belongsTo(
            AdditionalFilterAttribute::class,
            'additional_filter_attribute_id'
        );
    }

    public function attributeValue()
    {
        return $this->belongsTo(
            Attribute_values::class,
            'attribute_value_id'
        );
    }
}