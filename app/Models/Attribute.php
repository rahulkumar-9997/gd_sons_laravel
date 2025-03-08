<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute_values;
use App\Models\ProductAttributes;
use Illuminate\Support\Str;
class Attribute extends Model
{
    use HasFactory;
    protected $table = 'attributes';
    protected $fillable = [
        'id',
        'title',
        'slug',
        'description',
    ];
    public function AttributesValues()
    {
        return $this->hasMany(Attribute_values::class, 'attributes_id')->orderBy('sort_order', 'ASC');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'map_category_attributes', 'attribute_id', 'category_id');
    }

    public function mappedCategories()
    {
        return $this->belongsToMany(Category::class, 'map_category_attributes', 'attribute_id', 'category_id');
    }

    public function mappedCategoryToAttributesForFront()
    {
        return $this->hasMany(MappedCategoryToAttributesForFront::class, 'attributes_id');
    }

    public function mappedValuesForCategory()
    {
        return $this->hasMany(MapAttributesValueToCategory::class, 'attributes_id');
    }
    public function productAttributes()
    {
        return $this->hasMany(ProductAttributes::class, 'attributes_id', 'id');
    }   
    protected static function boot()
    {
        parent::boot();
        static::created(function ($facilities) {
            $facilities->slug = $facilities->createSlug($facilities->title);
            $facilities->save();
        });
    }
  
    private function createSlug($title){
        if (static::whereSlug($slug = Str::slug($title))->exists()) {
            $max = static::whereTitle($title)->latest('id')->skip(1)->value('slug');
            if (is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
  
            return "{$slug}-2";
        }
  
        return $slug;
    }
}
