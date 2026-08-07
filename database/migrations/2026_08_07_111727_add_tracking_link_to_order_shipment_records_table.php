<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrackingLinkToOrderShipmentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_shipment_records', function (Blueprint $table) {
            $table->string('tracking_link')->nullable()->after('tracking_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_shipment_records', function (Blueprint $table) {
            $table->dropColumn('tracking_link');
        });
    }
}
