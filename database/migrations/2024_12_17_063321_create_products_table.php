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
        Schema::create('products', function (Blueprint $table) {
            $table->id();  // Primary key column with auto-increment
            $table->unsignedBigInteger('category_id');  // Foreign key column
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('productname', 30);  // Product name
            $table->bigInteger('productprice');  // Price (no auto_increment)
            $table->string('brand', 30);  // Brand name
            $table->string('modelnumber', 20);  // Model number
            $table->string('warrantyperiod', 30);  // Warranty period
            // $table->text('ProductImage');  // Image
            $table->string('status', 10);  // Status
            $table->bigInteger('productstock');
            $table->text('description');  // Description
            $table->timestamps();  // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
