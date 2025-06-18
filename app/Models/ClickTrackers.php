<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickTrackers extends Model
{
    use HasFactory;
    protected $table = 'click_trackers';
    protected $fillable = [
        'button_type',
        'page_url',
        'ip_address',
        'click_time',
        'device_type'
    ];
}
