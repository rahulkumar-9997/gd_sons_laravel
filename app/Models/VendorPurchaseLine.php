<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPurchaseLine extends Model
{
    use HasFactory;
    protected $table = 'vendor_purchase_lines';
    protected $fillable = [
        'id',
        'vendor_purchase_bill_id',
        'product_id',
        'inventory_id',
        'mrp',
        'qty',
        'total_amount',
        'purchase_rate',
        'offer_rate',
        'hsn_code',
        'gst_dis_percentage',
    ];

    /* Define the relationship to the VendorPurchaseBill model*/
    public function purchaseBill()
    {
        return $this->belongsTo(VendorPurchaseBill::class, 'vendor_purchase_bill_id');
    }

    /*Define the relationship to the Product model*/
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
