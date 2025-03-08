<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('subcategory_id')->nullable();
            $table->unsignedInteger('brand_id')->nullable();
            $table->unsignedBigInteger('label_id')->nullable();
            $table->decimal('product_weight', 8, 2)->nullable();
            $table->boolean('product_stock_status')->default(1);
            $table->decimal('product_price', 8, 2)->nullable();
            $table->decimal('product_sale_price', 8, 2)->nullable();
            $table->boolean('product_status')->default(1);
            $table->boolean('warranty_status')->default(0);
            $table->boolean('attributes_show_status')->default(1);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->longText('product_description')->nullable();
            $table->longText('product_specification')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('sub_category')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brand')->onDelete('cascade');
            $table->foreign('label_id')->references('id')->on('label')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
