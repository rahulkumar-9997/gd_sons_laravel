<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingAndGatewayChargesToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('actual_shipping_amount', 10, 2)
                  ->default(0)
                  ->after('coupon_discount_amount');

            $table->decimal('payment_gateway_charges', 10, 2)
                  ->default(0)
                  ->after('actual_shipping_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'actual_shipping_amount',
                'payment_gateway_charges'
            ]);
        });
    }
}
