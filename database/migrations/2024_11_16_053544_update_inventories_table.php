<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->decimal('mrp')->nullable()->after('product_id')->change();
            $table->decimal('purchase_rate')->nullable()->after('mrp')->change();
            $table->decimal('offer_rate')->nullable()->after('purchase_rate')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->decimal('mrp')->nullable()->after('product_id')->change();
            $table->decimal('purchase_rate')->nullable()->after('mrp')->change();
            $table->decimal('offer_rate')->nullable()->after('purchase_rate')->change();
        });
    }
}
