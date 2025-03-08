<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogParagraph extends Model
{
    use HasFactory;
    protected $table = 'blog_paragraphs';
    protected $fillable = [
        'id',
        'blog_id',
        'paragraphs_title',
        'bog_paragraph_description',
        'bog_paragraph_image'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }
    
    public function productLinks()
    {
        return $this->hasMany(BlogParagraphProductLinks::class, 'blog_paragraphs_id', 'id');
        //return $this->hasOne(BlogParagraphProductLinks::class, 'blog_paragraphs_id', 'id');
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class, 
            BlogParagraphProductLinks::class, 
            'blog_paragraphs_id',  /*Foreign key on BlogParagraphProductLinks table*/
            'id',                  /*Foreign key on Product table*/
            'id',                  /*Local key on BlogParagraph table*/
            'product_id'           /*Local key on BlogParagraphProductLinks table*/
        );
    }
}
