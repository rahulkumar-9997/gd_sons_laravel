<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDimensionsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('length', 8, 2)->nullable()->after('product_sale_price')->comment('Length in cm');
            $table->decimal('breadth', 8, 2)->nullable()->after('length')->comment('Breadth in cm');
            $table->decimal('height', 8, 2)->nullable()->after('breadth')->comment('Height in cm');
            $table->decimal('weight', 8, 2)->nullable()->after('height')->comment('Weight in kg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['length', 'breadth', 'height', 'weight']);
        });
    }
}
