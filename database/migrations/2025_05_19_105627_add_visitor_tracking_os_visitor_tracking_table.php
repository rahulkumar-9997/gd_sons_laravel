<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisitorTrackingOsVisitorTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitor_tracking', function (Blueprint $table) {
             $table->string('device_type')->nullable()->after('page_title');
             $table->string('os')->nullable()->after('device_type');
             $table->string('referrer')->nullable()->after('os');
             $table->string('session_id')->nullable()->after('referrer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visitor_tracking', function (Blueprint $table) {
            //
        });
    }
}
