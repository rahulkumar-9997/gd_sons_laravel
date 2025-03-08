<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappedCategoryToAttributesForFront extends Model
{
    use HasFactory;
    protected $table = 'mapped_category_to_attributes_for_front';
    protected $fillable = [
        'id',
        'category_id',
        'attributes_id',
        'sort_order',
        'status',
    ];
}
