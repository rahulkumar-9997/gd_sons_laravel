<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaTracking extends Model
{
    use HasFactory;
    protected $table = 'social_media_tracking';
    protected $fillable = ['source', 'method', 'identity', 'ip_address', 'browser', 'page_name', 'location', 'visited_at'];
}
