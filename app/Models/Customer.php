<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public static function findByWhatsappNumberOrCreate($phoneNumber, $name = null)
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $phoneNumber);
        $customer = self::where('phone_number', $cleanPhone)->first();
        $randomPassword = Str::random(8);
        $hashedPassword = Hash::make($randomPassword);
        if (!$customer) {
            $password = Str::random(12); 
            $customer = self::create([
                'phone_number' => $cleanPhone,
                'name' => $name,
                'password' => $hashedPassword,
                'status' => true,
                'customer_id' => 'GD-' . time(),
            ]);
        }

        return $customer;
    }
    public function specialOffers()
    {
        return $this->hasMany(SpecialOffer::class, 'customer_id');
    }

    public function shiprocketCouriers()
    {
        return $this->hasMany(ShiprocketCourier::class);
    }
    
    
}
