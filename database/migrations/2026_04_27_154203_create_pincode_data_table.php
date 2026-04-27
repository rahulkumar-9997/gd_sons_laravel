<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePincodeDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pincode_data', function (Blueprint $table) {
            $table->id();
            $table->string('pincode', 20);
            $table->string('post_office', 100)->nullable();
            $table->integer('weight_450gm')->nullable();
            $table->integer('weight_750gm')->nullable();
            $table->integer('weight_1350gm')->nullable();
            $table->integer('weight_3400gm')->nullable();
            $table->integer('weight_7500gm')->nullable();
            $table->integer('weight_14kg')->nullable();
            $table->integer('weight_25kg')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pincode_data');
    }
}
