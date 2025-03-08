<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToVendorPurchaseBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_purchase_bills', function (Blueprint $table) {
            $table->string('bill_no')->nullable()->after('bill_date');
            $table->string('grand_total_amount')->nullable()->after('bill_no');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_purchase_bills', function (Blueprint $table) {
            $table->dropColumn(['bill_no', 'grand_total_amount']);
        });
    }
}
