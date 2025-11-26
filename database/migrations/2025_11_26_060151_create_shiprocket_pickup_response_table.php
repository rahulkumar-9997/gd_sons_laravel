<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiprocketPickupResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shiprocket_pickup_response', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id');
            $table->integer('pickup_status')->nullable();
            $table->string('pickup_scheduled_date')->nullable();
            $table->string('pickup_token_number')->nullable();
            $table->integer('status')->nullable();            
            $table->json('others')->nullable();
            $table->timestamp('pickup_generated_date')->nullable();
            $table->text('data')->nullable();
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
        Schema::dropIfExists('shiprocket_pickup_response');
    }
}
