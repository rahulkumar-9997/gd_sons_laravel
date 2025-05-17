<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentFieldsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('razorpay_payment_id')->nullable()->after('order_status_id');
            $table->string('razorpay_signature_id')->nullable()->after('razorpay_payment_id')->index();
            $table->string('razorpay_order_id')->nullable()->after('razorpay_signature_id');
            $table->string('razorpay_method')->nullable()->after('razorpay_order_id');       
            $table->string('payment_status')->default('Pending')->after('razorpay_method');
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
            //
        });
    }
}
