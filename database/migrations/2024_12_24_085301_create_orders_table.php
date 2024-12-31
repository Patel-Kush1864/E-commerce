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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('Order_id');
            $table->unsignedBigInteger('Client_id');  // Foreign key column
            $table->foreign('Client_id')->references('id')->on('registers')->onDelete('cascade')->onUpdate('cascade');
            $table->json('cartitems_id'); // Store cart item IDs as a JSON array
            $table->string('Fullname',100);
            $table->string('Email',30);
            $table->string('Country',30);
            $table->text('Address');
            $table->bigInteger('Mobile_no');
            $table->bigInteger('Pincode');
            $table->bigInteger('Total_items');
            $table->bigInteger('Subtotal');
            $table->bigInteger('Shipping_charges');
            $table->bigInteger('Total_amount');
            $table->string('Status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
