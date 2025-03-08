<?php

// app/Models/UserLogin.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'last_login_at',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

