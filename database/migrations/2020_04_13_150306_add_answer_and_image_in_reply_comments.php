<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnswerAndImageInReplyComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reply_comments', function (Blueprint $table) {
            $table->string('answer')->after('comment_id');
            $table->string('image')->nullable()->after('answer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reply_comments', function (Blueprint $table) {
            $table->dropColumn('answer');
            $table->dropColumn('image');
        });
    }
}
