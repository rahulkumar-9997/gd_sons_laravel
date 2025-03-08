<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogParagraphProductLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_paragraph_product_links', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('blog_paragraphs_id')->nullable();
            $table->string('links')->nullable();
            $table->timestamps();
            $table->foreign('blog_paragraphs_id')->references('id')->on('blog_paragraphs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_paragraph_product_links');
    }
}
