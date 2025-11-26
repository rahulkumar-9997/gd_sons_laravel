<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiprocketShipmentsAwbResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shiprocket_shipments_awb_response', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id');
            $table->string('shipment_id');
            $table->string('courier_company_id')->nullable();
            $table->string('awb_code')->nullable();
            $table->string('courier_name')->nullable();
            $table->float('applied_weight')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('child_courier_name')->nullable();
            $table->string('pickup_scheduled_date')->nullable();
            $table->string('routing_code')->nullable();
            $table->string('rto_routing_code')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('transporter_id')->nullable();
            $table->string('transporter_name')->nullable();
            $table->json('shipped_by')->nullable();            
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shiprocket_shipments_awb_response');
    }
}
