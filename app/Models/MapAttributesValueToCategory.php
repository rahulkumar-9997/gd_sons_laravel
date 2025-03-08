<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapAttributesValueToCategory extends Model
{
    use HasFactory;
    protected $table = 'map_attributes_values_to_category';
    protected $fillable = [
        'id',
        'category_id',
        'attributes_value_id',
        'attributes_id'
    ];
}
