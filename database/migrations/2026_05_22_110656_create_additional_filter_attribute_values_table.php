<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('additional_filter_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('additional_filter_attribute_id')->nullable();
            $table->unsignedInteger('attribute_value_id')->nullable();
            $table->timestamps();
            $table->foreign(
                'additional_filter_attribute_id',
                'afav_af_attr_id_fk'
            )
            ->references('id')
            ->on('additional_filter_attributes')
            ->onDelete('cascade');
            
            $table->foreign(
                'attribute_value_id',
                'afav_attr_val_id_fk'
            )
            ->references('id')
            ->on('attributes_value')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_filter_attribute_values');
    }
};