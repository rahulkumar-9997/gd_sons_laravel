<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupCategories extends Model
{
    use HasFactory;
    protected $table = 'groups_categories';
    protected $fillable = [
        'id',
        'name',
        'status',
        'group_category_percentage'
    ];

    public function groups()
    {
        return $this->hasMany(Groups::class, 'groups_category_id');
    }
    
}
