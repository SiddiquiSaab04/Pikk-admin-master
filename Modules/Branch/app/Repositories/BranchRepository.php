<?php

namespace Modules\Branch\app\Repositories;

use Exception;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Modules\Branch\app\Interfaces\BranchInterface;

class BranchRepository implements BranchInterface
{

    public function createOrderTable($id)
    {
        try {
            Schema::create("orders_$id", function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('customer_id');
                $table->float('code');
                $table->string('title');
                $table->string('type');
                $table->text('note')->nullable()->default(null);
                $table->string('status');
                $table->string('platform');
                $table->string('payment');
                $table->string('wallet')->nullable()->default(0);
                $table->float('discount')->nullable()->default(0);
                $table->string('discount_type')->nullable();
                $table->float('total');
                $table->float('sub_total');
                $table->string('cancelled_reason')->default(null);
                $table->softDeletes();
                $table->timestamps();
            });
        } catch (Exception $e) {
            Log::info("Some Error Occurred while creating orders table".$e->getMessage().' '.$e->getLine());
        }
    }

    public function createOrderProductTable($id)
    {
        try {
            Schema::create("order_products_$id", function (Blueprint $table) use ($id){
                $table->bigIncrements('id');
                $table->unsignedBigInteger('order_id');
                $table->foreign('order_id')->references('id')->on("orders_$id");
                $table->unsignedBigInteger('product_id');
                $table->foreign('product_id')->references('id')->on('products');
                $table->unsignedBigInteger('category_id');
                $table->foreign('category_id')->references('id')->on('categories');
                $table->string('product_name');
                $table->integer('quantity');
                $table->float("unit_price");
                $table->float("total_price");
                $table->softDeletes();
                $table->timestamps();
            });
        } catch (Exception $e) {
            Log::info("Some Error Occurred while creating order products table".$e->getMessage().' '.$e->getLine());
        }
    }

    public function createOrderProductAddonTable($id)
    {
        try {
            Schema::create("order_product_addons_$id", function (Blueprint $table) use ($id){
                $table->bigIncrements('id');
                $table->unsignedBigInteger('order_id');
                $table->foreign('order_id')->references('id')->on("orders_$id");
                $table->unsignedBigInteger('product_id');
                $table->foreign('product_id')->references('id')->on('products');
                $table->unsignedBigInteger('order_product_id');
                $table->foreign('order_product_id')->references('id')->on("order_products_$id");
                $table->string('product_name');
                $table->integer('quantity');
                $table->float("unit_price");
                $table->float("total_price");
                $table->softDeletes();
                $table->timestamps();
            });
        } catch (Exception $e) {
            Log::info("Some Error Occurred while creating order product addons table".$e->getMessage().' '.$e->getLine());
        }
    }

    public function createProductStockTable($id)
    {
        try {
            Schema::create("product_stocks_$id", function (Blueprint $table) use ($id){
                $table->bigIncrements('id');
                $table->unsignedBigInteger('product_id');
                $table->integer('is_enabled')->nullable()->default(1);
                $table->integer('available_stock')->nullable()->default(1);
                $table->integer('default_quantity')->nullable()->default(1);
                $table->softDeletes();
                $table->timestamps();
            });
        } catch (Exception $e) {
            Log::info("Some Error Occurred while creating product stocks table".$e->getMessage().' '.$e->getLine());
        }
    }
}
