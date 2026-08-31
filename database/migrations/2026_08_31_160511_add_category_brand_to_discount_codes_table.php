<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryBrandToDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discount_codes', function (Blueprint $table) {
            $table->unsignedInteger('category_id')
                  ->nullable()
                  ->after('discount_value');

            $table->unsignedInteger('attributes_value_id')
                  ->nullable()
                  ->after('category_id');

            $table->foreign('category_id')
                  ->references('id')
                  ->on('category')
                  ->nullOnDelete();

            $table->foreign('attributes_value_id')
                  ->references('id')
                  ->on('attributes_value')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discount_codes', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['attributes_value_id']);
            $table->dropColumn(['category_id', 'attributes_value_id']);
        });
    }
}
