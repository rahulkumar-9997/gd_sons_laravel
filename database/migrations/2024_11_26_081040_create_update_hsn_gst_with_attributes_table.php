<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdateHsnGstWithAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('update_hsn_gst_with_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('attributes_id');
            $table->unsignedInteger('attributes_value_id');
            $table->string('hsn_code')->nullable();
            $table->string('gst_in_per')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
            $table->foreign('attributes_id')->references('id')->on('attributes')->onDelete('cascade');
            $table->foreign('attributes_value_id')->references('id')->on('attributes_value')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('update_hsn_gst_with_attributes');
    }
}
