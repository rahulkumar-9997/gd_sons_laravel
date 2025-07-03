<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileTypeToProductReviewFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_review_files', function (Blueprint $table) {
            $table->string('file_type')->nullable()->after('review_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_review_files', function (Blueprint $table) {
           $table->dropColumn('file_type');
        });
    }
}
