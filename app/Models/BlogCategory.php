<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $table = 'blog_categories';
    protected $fillable = [
        'id',
        'title',
        'slug',
        'status'
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'blog_category_id', 'id');
    }
    
}
