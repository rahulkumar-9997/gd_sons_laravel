<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $fillable = [
        'id',
        'title',
        'category_heading',
        'hsn_code',
        'description',
        'slug',
        'image',
        'status',
        'trending',
    ];
    public function mapCategoryAttributes()
    {
        return $this->hasMany(MapCategoryAttributes::class, 'category_id', 'id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'map_category_attributes', 'category_id', 'attribute_id');
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function attributesWithMappedValues()
    {
        return $this->belongsToMany(Attribute::class, 'map_category_attributes', 'category_id', 'attribute_id')
            ->with(['AttributesValues' => function ($query) {
                $query->with('map_attributes_value_to_categories');
            }]);
    }
    
    protected static function boot()
    {
        parent::boot();
        static::created(function ($facilities) {
            $facilities->slug = $facilities->createSlug($facilities->title);
            $facilities->save();
        });
    }
  
    /** 
     * Write code on Method
     *
     * @return response()
     */
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
