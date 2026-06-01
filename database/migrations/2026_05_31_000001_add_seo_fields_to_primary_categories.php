<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeoFieldsToPrimaryCategories extends Migration
{
    public function up()
    {
        Schema::table('primary_categories', function (Blueprint $table) {
            $table->string('meta_title', 70)->nullable()->after('title');
            $table->string('meta_description', 160)->nullable()->after('meta_title');
            $table->string('h1_text', 120)->nullable()->after('meta_description');
        });
    }

    public function down()
    {
        Schema::table('primary_categories', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'h1_text']);
        });
    }
}