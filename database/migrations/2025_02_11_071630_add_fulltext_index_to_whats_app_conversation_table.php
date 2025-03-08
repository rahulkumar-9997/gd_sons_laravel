<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFulltextIndexToWhatsAppConversationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('whats_app_conversation', function (Blueprint $table) {
            $table->fullText(['name', 'mobile_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('whats_app_conversation', function (Blueprint $table) {
            $table->dropFullText(['name', 'mobile_number']);
        });
    }
}
