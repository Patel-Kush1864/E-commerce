<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id'); // Ensure the foreign keys match
    }

}
