<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TrackVisitorProduct extends Model
{
    public const LIMIT = 25;

    protected $table = 'track_visitor_products';
    public $timestamps = false;
    protected $fillable = ['product_id', 'visited_at'];

    public static function latestIds(): array
    {
        return Cache::rememberForever('track_visitor_product_ids', function () {
            return static::orderByDesc('visited_at')
                ->orderByDesc('id')
                ->pluck('product_id')
                ->all();
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public static function record(int $productId): void
    {
        Cache::lock('track_visitor_products_lock', 5)->block(3, function () use ($productId) {
            if (static::where('product_id', $productId)->exists()) {
                return;
            }
            $extra = static::count() - (static::LIMIT - 1);
            if ($extra > 0) {
                $oldIds = static::orderBy('visited_at')->orderBy('id')->limit($extra)->pluck('id');
                static::whereIn('id', $oldIds)->delete();
            }
            static::create(['product_id' => $productId, 'visited_at' => now()]);
            Cache::forget('track_visitor_product_ids');
        });
    }
}