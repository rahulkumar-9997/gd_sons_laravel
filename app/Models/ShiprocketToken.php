<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiprocketToken extends Model
{
    protected $table = 'shiprocket_tokens';
    protected $fillable = [
        'token',
        'token_created_at',
    ];
    public $timestamps = true;
}
