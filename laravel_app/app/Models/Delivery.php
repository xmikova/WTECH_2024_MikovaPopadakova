<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = ['type', 'price'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
