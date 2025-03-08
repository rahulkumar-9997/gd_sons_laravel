<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorPurchaseLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_purchase_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('vendor_purchase_bill_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('inventory_id')->nullable();
            $table->decimal('mrp', 30, 2)->nullable();
            $table->decimal('qty', 30, 2)->nullable();
            $table->decimal('total_amount', 30, 2)->nullable(); 
            $table->decimal('purchase_rate', 30, 2)->default(0);
            $table->decimal('offer_rate', 30, 2)->default(0);
            $table->integer('gst_dis_percentage')->default(0);
            $table->timestamps(); 
            $table->foreign('vendor_purchase_bill_id')->references('id')->on('vendor_purchase_bills')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('set null');
            
            // Adding indexes for performance
            $table->index('vendor_purchase_bill_id');
            $table->index('product_id');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_purchase_lines');
    }
}
