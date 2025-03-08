<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_category', function (Blueprint $table) {
            // $table->id(); 
            // $table->string('title');
            // $table->foreignId('category_id')
            //       ->constrained('category')
            //       ->onDelete('cascade');
            // $table->string('image')->nullable(); 
            // $table->boolean('status')->default(true);
            // $table->timestamps(); 



            $table->increments('id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')
                  ->references('id')->on('category')
                  ->onDelete('cascade');
            $table->string('image')->nullable(); 
            $table->string('status')->default('off')->comment('Status of the item');
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
        Schema::dropIfExists('sub_category');
    }
}
