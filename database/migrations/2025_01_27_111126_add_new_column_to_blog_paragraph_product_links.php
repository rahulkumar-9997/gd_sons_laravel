<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToBlogParagraphProductLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_paragraph_product_links', function (Blueprint $table) {
            $table->unsignedInteger('product_id')->nullable()->after('links'); 
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_paragraph_product_links', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');   
        });
    }
}
