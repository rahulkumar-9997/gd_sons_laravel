<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalFilter extends Model
{
    use HasFactory;
    protected $table = 'additional_filters';

    protected $fillable = [
        'category_id',
        'filter_button_name',
        'slug',
        'sort_order',
        'status',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function filterAttributes()
    {
        return $this->hasMany(
            AdditionalFilterAttribute::class,
            'additional_filter_id'
        );
    }
}