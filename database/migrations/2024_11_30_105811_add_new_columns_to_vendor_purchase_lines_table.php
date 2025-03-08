<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToVendorPurchaseLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_purchase_lines', function (Blueprint $table) {
            $table->string('pre_gst_amount')->nullable()->after('gst_dis_percentage');
            $table->string('gst_amount')->nullable()->after('pre_gst_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_purchase_lines', function (Blueprint $table) {
            $table->dropColumn(['pre_gst_amount', 'gst_amount']);
        });
    }
}
