<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedProduct extends Model
{
    use HasFactory;
    protected $table = 'related_products';
    protected $fillable = [
        'variant_id',
        'product_id',
        'relation_type',
        'title',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }   
}