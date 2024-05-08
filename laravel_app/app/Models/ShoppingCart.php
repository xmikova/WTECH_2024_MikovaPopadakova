<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function items()
    {
        return $this->belongsToMany(CartItem::class, 'cart_item_shopping_cart', 'shopping_cart_id', 'cart_item_id');
    }
}


