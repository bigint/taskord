<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteNotificationsFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('taskMentionedEmail');
            $table->dropColumn('taskMentionedWeb');
            $table->dropColumn('taskPraisedEmail');
            $table->dropColumn('taskPraisedWeb');
            $table->dropColumn('commentPraisedEmail');
            $table->dropColumn('commentPraisedWeb');
            $table->dropColumn('questionPraisedEmail');
            $table->dropColumn('questionPraisedWeb');
            $table->dropColumn('answerPraisedEmail');
            $table->dropColumn('answerPraisedWeb');
            $table->dropColumn('commentAddedEmail');
            $table->dropColumn('commentAddedWeb');
            $table->dropColumn('answerAddedEmail');
            $table->dropColumn('answerAddedWeb');
            $table->dropColumn('userFollowedEmail');
            $table->dropColumn('userFollowedWeb');
            $table->dropColumn('productSubscribedWeb');
            $table->dropColumn('productSubscribedEmail');
            $table->dropColumn('productUpdatesWeb');
            $table->dropColumn('productUpdatesEmail');
            $table->boolean('notifications_email')->default(true);
            $table->boolean('notifications_web')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
