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
            $table->id();
            $table->string('name');
            $table->string('sku');
            $table->string('barcode')->nullable();
            $table->string("preview_url");
            $table->string("description");
            $table->float("wholesale_price");
            $table->float("sale_price");
            $table->tinyInteger("stock_checking")->default(1);
            $table->tinyInteger("sort_order")->default(1);
            $table->tinyInteger("status")->default(1);
            $table->unsignedBigInteger('category_id');
            $table->foreign("category_id")->references("id")->on("categories");
            $table->timestamps();
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
