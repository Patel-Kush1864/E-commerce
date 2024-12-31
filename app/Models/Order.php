<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'Order_id';

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'Cart_id'); // Ensure the foreign keys match
    }

}
