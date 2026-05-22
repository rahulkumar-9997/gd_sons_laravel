<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalFilterAttribute extends Model
{
    use HasFactory;
    protected $table = 'additional_filter_attributes';

    protected $fillable = [
        'additional_filter_id',
        'attribute_id',
    ];

    public function additionalFilter()
    {
        return $this->belongsTo(
            AdditionalFilter::class,
            'additional_filter_id'
        );
    }

    public function attribute()
    {
        return $this->belongsTo(
            Attribute::class,
            'attribute_id'
        );
    }

    public function attributeValues()
    {
        return $this->hasMany(
            AdditionalFilterAttributeValue::class,
            'additional_filter_attribute_id'
        );
    }
}