<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'Cart_id';
    protected $guarded = [];

    public function cartItems()
    {
        return $this->hasMany(Cartitem::class, 'Cart_id');
    }
   
}
