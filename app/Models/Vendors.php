<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    use HasFactory;
    protected $table = 'vendors';
    protected $fillable = [
        'id',
        'vendor_name',
        'location',
        'gst_no',
        'contact_no',
        'created_at',
        'updated_at'
    ];
   
    /* Define the relationship between Vendor and VendorPurchaseBill*/
    public function purchaseBills()
    {
        return $this->hasMany(VendorPurchaseBill::class, 'vendor_id');
    }
}
