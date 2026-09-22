<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_products', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('supply_id')->nullable();
            $table->unsignedInteger('product_id')->nullable(); 
            $table->unsignedInteger('qty')->default(1);
            $table->string('unit')->nullable(); 
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->foreign('supply_id')->references('id')->on('supplies')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supply_products');
    }
}
