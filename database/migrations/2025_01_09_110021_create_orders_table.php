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
            $table->id();
            $table->unsignedBigInteger('client_id');  // Foreign key column
            $table->foreign('client_id')->references('id')->on('registers')->onDelete('cascade')->onUpdate('cascade');
            $table->json('cartitems_id'); // Store cart item IDs as a JSON array
            $table->string('fullname',100);
            $table->string('email',30);
            $table->string('country',30);
            $table->text('address');
            $table->bigInteger('mobile_no');
            $table->bigInteger('pincode');
            $table->bigInteger('total_items');
            $table->bigInteger('subtotal');
            $table->bigInteger('shipping_charges');
            $table->bigInteger('total_amount');
            $table->string('status');
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
