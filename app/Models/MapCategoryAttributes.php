<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapCategoryAttributes extends Model
{
    use HasFactory;
    protected $table = 'map_category_attributes';
    protected $fillable = [
        'id',
        'category_id',
        'attribute_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
