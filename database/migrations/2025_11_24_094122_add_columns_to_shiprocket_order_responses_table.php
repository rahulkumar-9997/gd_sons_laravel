<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToShiprocketOrderResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shiprocket_order_responses', function (Blueprint $table) {
            $table->boolean('is_order_created')->default(0)->after('create_order_date');
            $table->boolean('is_order_updated')->default(0)->after('is_order_created');
            $table->boolean('is_order_cancelled')->default(0)->after('is_order_updated');
            $table->boolean('is_address_updated')->default(0)->after('is_order_cancelled');
            $table->boolean('is_awb_generated')->default(0)->after('is_address_updated');
            $table->boolean('is_pickup_requested')->default(0)->after('is_awb_generated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shiprocket_order_responses', function (Blueprint $table) {
            $table->dropColumn([
                'is_order_created',
                'is_order_updated',
                'is_order_cancelled',
                'is_address_updated',
                'is_awb_generated',
                'is_pickup_requested',
            ]);
        });
    }
}
