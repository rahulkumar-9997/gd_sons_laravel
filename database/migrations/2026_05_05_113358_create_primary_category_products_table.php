<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrimaryCategoryProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primary_category_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('primary_category_id');
            $table->unsignedInteger('product_id');
            $table->timestamps();
            $table->foreign('primary_category_id')
                ->references('id')
                ->on('primary_categories')
                ->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('primary_category_products');
    }
}
