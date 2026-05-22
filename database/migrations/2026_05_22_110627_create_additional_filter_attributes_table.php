<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('additional_filter_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('additional_filter_id')->nullable();
            $table->unsignedInteger('attribute_id')->nullable();
            $table->timestamps();
            $table->foreign('additional_filter_id')
                  ->references('id')
                  ->on('additional_filters')
                  ->onDelete('cascade');
            $table->foreign('attribute_id')
                  ->references('id')
                  ->on('attributes')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('additional_filter_attributes');
    }
};