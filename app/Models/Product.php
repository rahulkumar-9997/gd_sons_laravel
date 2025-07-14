<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\ProductImages;
use App\Models\ProductAttributes;
use App\Models\Category;
class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'id',
        'title',
        'visitor_count',
        'hsn_code',
        'gst_in_per',
        'slug',
        'category_id',
        'subcategory_id',
        'brand_id',
        'label_id',
        'g_tin_no',
        'product_weight',
        'product_stock_status',
        'product_tags',
        'product_price',
        'product_sale_price',
        'product_status',
        'warranty_status',
        'attributes_show_status',
        'meta_title',
        'meta_description',
        'product_description',
        'product_specification',
        'video_id',
        'created_at',
    ];


    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttributes::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**display product with product image relationship in front page  */
    public function ProductImagesFront()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'id') ->orderBy('sort_order', 'asc')
        ->limit(2);
    }
    /**display product with product image relationship in front page  */
    /**FIND PRODUCT LIST WHERE PRODUCT ATTRIBUTES VALUE RELATIONSHIP FOR BACKEND*/
    public function productAttributesValuesForBackend(){
        return $this->hasManyThrough(
            ProductAttributesValues::class,
            ProductAttributes::class,
            'product_id', /*Foreign key on ProductAttributes table*/
            'product_attribute_id', /*Foreign key on ProductAttributesValues table*/
            'id', /* Local key on Products table*/
            'id'  /* Local key on ProductAttributes table*/
        );
    }
    /**FIND PRODUCT LIST WHERE PRODUCT ATTRIBUTES VALUE RELATIONSHIP FOR BACKEND */
    /**find product addition feature value */
    public function additionalFeatures(){
        return $this->hasMany(ProductsAdditionalFeature::class, 'product_id', 'id')->with('feature');
    }
    /**inventory relationship */
    public function inventories(){
        return $this->hasMany(Inventory::class, 'product_id', 'id');
    }
    

    /* Define the relationship to VendorPurchaseLine*/
    public function purchaseLines()
    {
        return $this->hasMany(VendorPurchaseLine::class, 'product_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($facilities) {
            $facilities->slug = $facilities->createSlug($facilities->title);
            $facilities->save();
        });
    }
    public function productAttributesValues()
    {
        return $this->hasMany(ProductAttributesValues::class, 'product_id');
    }

    public function firstImage()
    {
        return $this->hasOne(ProductImages::class, 'product_id')->orderBy('id', 'asc');
    }

    public function firstSortedImage()
    {
        return $this->hasOne(ProductImages::class, 'product_id')->orderBy('sort_order', 'asc');
    }
    
    public function orderLines()
    {
        return $this->hasMany(OrderLines::class, 'product_id');
    }
    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id', 'id');
    }

    public function specialOffers()
    {
        return $this->hasMany(SpecialOffer::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class)->where('status', '1');
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
