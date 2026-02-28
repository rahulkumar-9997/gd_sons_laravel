<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsageLimitsToDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discount_codes', function (Blueprint $table) {
            $table->integer('usage_limit')->default(0)->after('maximum_discount')->comment('0 means unlimited');
            $table->integer('total_used')->default(0)->after('usage_limit');
            $table->text('used_by_ips')->nullable()->after('total_used')->comment('Comma separated IPs or JSON');
            $table->text('used_by_customers')->nullable()->after('used_by_ips')->comment('Comma separated customer IDs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discount_codes', function (Blueprint $table) {
            $table->dropColumn(['usage_limit', 'total_used', 'used_by_ips', 'used_by_customers']);
        });
    }
}
