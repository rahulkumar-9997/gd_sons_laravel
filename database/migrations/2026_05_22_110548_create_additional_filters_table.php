<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('additional_filters', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id');
            $table->string('filter_button_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('sort_order')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->foreign('category_id')
                  ->references('id')
                  ->on('category')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_filters');
    }
};