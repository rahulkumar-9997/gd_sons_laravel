<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPurchaseBill extends Model
{
    use HasFactory;
    protected $table = 'vendor_purchase_bills';
    protected $fillable = [
        'id',
        'vendor_id',
        'bill_date',
        'bill_no',
        'grand_total_amount'
    ];

    /*Define the relationship to the Vendor model*/
    public function vendor()
    {
        return $this->belongsTo(Vendors::class, 'vendor_id');
    }

    /*Define the relationship to VendorPurchaseLine*/
    public function purchaseLines()
    {
        return $this->hasMany(VendorPurchaseLine::class, 'vendor_purchase_bill_id');
    }

}
