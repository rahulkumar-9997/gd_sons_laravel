<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEnquiry extends Model
{
    use HasFactory;
    protected $table = 'product_enquiries';
    protected $fillable = ['name', 'phone', 'message', 'reload_modal'];
}
