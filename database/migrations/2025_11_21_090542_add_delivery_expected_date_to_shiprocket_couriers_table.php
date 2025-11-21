<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryExpectedDateToShiprocketCouriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shiprocket_couriers', function (Blueprint $table) {
            $table->string('delivery_expected_date')->nullable()->after('cod_charges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shiprocket_couriers', function (Blueprint $table) {
            $table->dropColumn('delivery_expected_date');
        });
    }
}
