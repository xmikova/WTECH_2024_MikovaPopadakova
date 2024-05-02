<?php

// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'cart_id',
        'customer_info_id',
        'delivery_info_id',
        'payment_info_id',
        'totalPrice',
        'createdAt',
        'state'
    ];

    public function cart()
    {
        return $this->belongsTo(ShoppingCart::class);
    }

    public function customerInfo()
    {
        return $this->belongsTo(CustomerInfo::class);
    }

    public function deliveryInfo()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function paymentInfo()
    {
        return $this->belongsTo(Payment::class);
    }
}

