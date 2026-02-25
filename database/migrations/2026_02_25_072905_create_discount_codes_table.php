<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->string('discount_code', 50)->unique();
            $table->enum('mode', ['Amount', 'Percentage']);
            $table->decimal('discount_value', 10, 2);
            $table->date('valid_from')->nullable();
            $table->date('valid_till')->nullable();
            $table->string('short_description')->nullable();
            $table->decimal('minimum_order_value', 10, 2)->default(0);
            $table->decimal('maximum_discount', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('discount_codes');
    }
}
