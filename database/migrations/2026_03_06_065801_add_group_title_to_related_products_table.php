<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupTitleToRelatedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('related_products', function (Blueprint $table) {
            $table->string('group_title')->nullable()->after('variant_id');
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
            $table->dropColumn('group_title');
        });
    }
}
