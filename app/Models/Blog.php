<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    protected $fillable = [
        'id',
        'title',
        'slug',
        'status',
        'blog_category_id',
        'bog_description',
        'blog_image',
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');
    }
    
    public function paragraphs()
    {
        return $this->hasMany(BlogParagraph::class, 'blog_id', 'id');
    }
}
