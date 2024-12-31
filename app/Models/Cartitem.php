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
        return $this->belongsTo(Order::class, 'Cart_id'); // Foreign key is Cart_id
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'Prod_id'); // Foreign key is Prod_id
    }
    
}
