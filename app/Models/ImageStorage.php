<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageStorage extends Model
{
    use HasFactory;
    protected $table = 'image_storage';
    protected $fillable = [
        'id',
        'image_storage_path',
    ];
}
