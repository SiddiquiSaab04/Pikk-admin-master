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
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('cashback_points');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->decimal('cashback_points', 10, 2)->nullable()->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('cashback_points');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('cashback_points')->nullable()->default(0);
        });
    }
};
