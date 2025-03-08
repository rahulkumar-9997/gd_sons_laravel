<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdditionalFeature extends Model
{
    use HasFactory;

    protected $table = 'additional_features';

    protected $fillable = [
        'id',
        'title',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($title) {
            $title->slug = $title->createSlug($title->title);
            $title->save();
        });
    }

    /**
     * Generate a unique slug based on the title
     *
     * @return string
     */
    private function createSlug($title)
    {
        $slug = Str::slug($title);
        if (static::whereSlug($slug)->exists()) {
            $max = static::whereTitle($title)->latest('id')->skip(1)->value('slug');
            if ($max !== null && is_string($max) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($matches) {
                    return $matches[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }
}
