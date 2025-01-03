<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartitem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'cart_id'); // Foreign key is Cart_id
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Foreign key is Prod_id
    }
    
}
