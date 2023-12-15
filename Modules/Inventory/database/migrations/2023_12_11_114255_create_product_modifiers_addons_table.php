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
        Schema::create('product_modifiers_addons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_modifiers_id");
            $table->unsignedBigInteger("product_id");
            $table->foreign("product_modifier_id")->references("id")->on("product_modifiers");
            $table->foreign("product_id")->references("id")->on("products");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_modifiers_addons');
    }
};
