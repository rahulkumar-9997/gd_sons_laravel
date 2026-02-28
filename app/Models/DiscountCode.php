<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DiscountCode extends Model
{
    use HasFactory;
    protected $table = 'discount_codes';
    protected $fillable = [
        'discount_code',
        'mode',
        'discount_value',
        'valid_from',
        'valid_till',
        'short_description',
        'minimum_order_value',
        'maximum_discount',
        'is_active',
        'usage_limit',
        'total_used',
        'used_by_ips',
        'used_by_customers'
    ];
    protected $casts = [
        'valid_from' => 'date',
        'valid_till' => 'date',
        'is_active'  => 'boolean',
        'usage_limit' => 'integer',
        'total_used' => 'integer',
    ];

     public function canUse($customerId = null, $ip = null)
    {
        if (!$this->is_active || 
            Carbon::now()->lt($this->valid_from) || 
            Carbon::now()->gt($this->valid_till)) {
            return false;
        }
        if ($this->usage_limit > 0 && $this->total_used >= $this->usage_limit) {
            return false;
        }
        if ($ip && $this->used_by_ips) {
            $usedIps = explode(',', $this->used_by_ips);
            if (in_array($ip, $usedIps)) {
                return false;
            }
        }
        if ($customerId && $this->used_by_customers) {
            $usedCustomers = explode(',', $this->used_by_customers);
            if (in_array($customerId, $usedCustomers)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Mark coupon as used
     */
    public function markAsUsed($customerId = null, $ip = null)
    {
        if ($ip) {
            $usedIps = $this->used_by_ips ? explode(',', $this->used_by_ips) : [];
            if (!in_array($ip, $usedIps)) {
                $usedIps[] = $ip;
                $this->used_by_ips = implode(',', array_filter($usedIps));
            }
        }
        if ($customerId) {
            $usedCustomers = $this->used_by_customers ? explode(',', $this->used_by_customers) : [];
            if (!in_array($customerId, $usedCustomers)) {
                $usedCustomers[] = $customerId;
                $this->used_by_customers = implode(',', array_filter($usedCustomers));
            }
        }
        $this->total_used = $this->total_used + 1;        
        return $this->save();
    }
}
