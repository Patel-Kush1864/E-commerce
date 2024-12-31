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
            $table->id('Prod_id');  // Primary key column with auto-increment
            $table->unsignedBigInteger('category_id');  // Foreign key column
            $table->foreign('category_id')->references('Cate_id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('ProductName', 30);  // Product name
            $table->bigInteger('ProductPrice');  // Price (no auto_increment)
            $table->string('Brand', 30);  // Brand name
            $table->string('ModelNumber', 20);  // Model number
            $table->string('WarrantyPeriod', 30);  // Warranty period
            // $table->text('ProductImage');  // Image
            $table->string('Status', 10);  // Status
            $table->bigInteger('ProductStock');
            $table->text('Description');  // Description
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
