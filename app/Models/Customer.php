<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'customers';

    protected $fillable = [
        'id',
        'group_id', 
        'name', 
        'email', 
        'customer_id', 
        'password', 
        'google_id', 
        'profile_img', 
        'phone_number', 
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];
    // public function groupCategory(){
    //     return $this->belongsTo(GroupCategories::class, 'group_category_id');
    // }

    public function groups(){
        return $this->groupCategory()->with('groups');
    }

    public function customerGroup()
    {
        return $this->belongsTo(Groups::class, 'group_id');
    }

    public function groupCategory()
    {
        return $this->hasOneThrough(
            GroupCategories::class, 
            Groups::class, 
            'id',         
            'id',
            'group_id', 
            'groups_category_id'
        );
    }
    
    
}
