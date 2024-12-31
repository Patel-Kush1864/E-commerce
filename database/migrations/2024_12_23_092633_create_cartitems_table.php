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
        Schema::create('cartitems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Cart_id');  // Foreign key column
            $table->foreign('Cart_id')->references('Cart_id')->on('carts')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('Prod_id');  // Foreign key column
            $table->foreign('Prod_id')->references('Prod_id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('Quantities'); // Column to store product quantities as JSON
            $table->decimal('Price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartitems');
    }
};
