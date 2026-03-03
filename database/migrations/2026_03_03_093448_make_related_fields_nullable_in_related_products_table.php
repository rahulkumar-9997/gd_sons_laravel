<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeRelatedFieldsNullableInRelatedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('related_products', function (Blueprint $table) {
            $table->unsignedInteger('related_product_id')->nullable()->change();
            $table->string('relation_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('related_products', function (Blueprint $table) {
            $table->unsignedInteger('related_product_id')->nullable(false)->change();
            $table->string('relation_type')->nullable(false)->change();
        });
    }
}
