<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_date');
            $table->string('order_id')->unique();
            $table->string('grand_total_amount');
            $table->string('payment_mode');
            $table->boolean('payment_received')->default(0);
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('shipping_address_id');
            $table->unsignedInteger('billing_address_id')->nullable();
            $table->unsignedInteger('order_status_id')->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('shipping_address_id')->references('id')->on('shipping_addresses')->onDelete('cascade');
            $table->foreign('billing_address_id')->references('id')->on('billing_addresses')->onDelete('cascade');
            $table->foreign('order_status_id')->references('id')->on('order_status')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
