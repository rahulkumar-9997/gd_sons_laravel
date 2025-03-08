<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogParagraphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_paragraphs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('blog_id')->nullable();
            $table->longText('bog_paragraph_description')->nullable();
            $table->string('bog_paragraph_image')->nullable();
            $table->timestamps();
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_paragraphs');
    }
}
