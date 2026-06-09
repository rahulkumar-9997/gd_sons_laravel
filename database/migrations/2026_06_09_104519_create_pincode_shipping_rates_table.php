<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePincodeShippingRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pincode_shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pincode_id')->constrained()->cascadeOnDelete();
            $table->foreignId('weight_category_id')->constrained()->cascadeOnDelete();
            $table->decimal('shipping_rate', 10, 2)->default(0);
            $table->timestamps();
            $table->unique(['pincode_id', 'weight_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pincode_shipping_rates');
    }
}
