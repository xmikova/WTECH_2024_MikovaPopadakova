<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'factural_name',
        'factural_address',
        'factural_postal_code',
        'factural_city',
        'factural_phone_number',
        'billing_name',
        'billing_address',
        'billing_postal_code',
        'billing_city',
        'billing_phone_number',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

