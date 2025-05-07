<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsAppConversationMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whats_app_conversation_message', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('whats_app_conversation_id');
            $table->string('reply')->nullable();
            $table->longText('conversation_message')->nullable();
            $table->timestamps();
            $table->foreign('whats_app_conversation_id')->references('id')->on('whats_app_conversation')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whats_app_conversation_message');
    }
}
