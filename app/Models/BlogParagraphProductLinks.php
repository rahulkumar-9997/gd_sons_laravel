<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogParagraphProductLinks extends Model
{
    use HasFactory;
    protected $table = 'blog_paragraph_product_links';
    protected $fillable = [
        'id',
        'blog_paragraphs_id',
        'links',
        'product_id',
    ];

    public function paragraph()
    {
        return $this->belongsTo(BlogParagraph::class, 'blog_paragraphs_id', 'id');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
