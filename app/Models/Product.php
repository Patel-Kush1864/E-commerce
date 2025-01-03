<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

   
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // Specify foreign key if needed
    }
    // // Define the relationship with ProductImage
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
  
    
}
