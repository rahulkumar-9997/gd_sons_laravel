<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $fillable = [
        'id',
        'groups_category_id',
        'name',
    ];
    public function groupCategory()
    {
        return $this->belongsTo(GroupCategories::class, 'groups_category_id');
    }
}
