<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialMediaTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_media_tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->string('source')->nullable();
            $table->string('method')->nullable();
            $table->string('identity')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('browser')->nullable();
            $table->text('page_name')->nullable();
            $table->json('location')->nullable();
            $table->timestamp('visited_at')->useCurrent()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_media_tracking');
    }
}
