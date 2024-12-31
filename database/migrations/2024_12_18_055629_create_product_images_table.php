<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id('Img_id');
            $table->unsignedBigInteger('Product_id');  // Foreign key column
            $table->foreign('Product_id')->references('Prod_id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->text('ProductImage'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
