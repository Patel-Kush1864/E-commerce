<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $primaryKey = 'Prod_id';

   
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','Cate_id');
    }

    // Define the relationship with ProductImage
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'Product_id');
    }
    
}
