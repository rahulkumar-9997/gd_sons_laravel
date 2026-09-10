<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (!Schema::hasColumn('inventories', 'offer_shipment_rate')) {
                $table->decimal('offer_shipment_rate', 10, 2)->nullable()->after('shipment_rate');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (Schema::hasColumn('inventories', 'offer_shipment_rate')) {
                $table->dropColumn('offer_shipment_rate');
            }
        });
    }
};