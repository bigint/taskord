<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserNotificationsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
            // Task Mentioned
            $table->boolean('taskMentionedEmail')->default(true);
            $table->boolean('taskMentionedWeb')->default(true);

            // Task Praised
            $table->boolean('taskPraisedEmail')->default(false);
            $table->boolean('taskPraisedWeb')->default(true);

            // Comment Praised
            $table->boolean('commentPraisedEmail')->default(false);
            $table->boolean('commentPraisedWeb')->default(true);

            // Question Praised
            $table->boolean('questionPraisedEmail')->default(false);
            $table->boolean('questionPraisedWeb')->default(true);

            // Answer Praised
            $table->boolean('answerPraisedEmail')->default(false);
            $table->boolean('answerPraisedWeb')->default(true);

            // Comment Added
            $table->boolean('commentAddedEmail')->default(true);
            $table->boolean('commentAddedWeb')->default(true);

            // Answer Added
            $table->boolean('answerAddedEmail')->default(true);
            $table->boolean('answerAddedWeb')->default(true);

            // User Followed
            $table->boolean('userFollowedEmail')->default(true);
            $table->boolean('userFollowedWeb')->default(true);

            // Product Subscribed
            $table->boolean('productSubscribedWeb')->default(true);
            $table->boolean('productSubscribedEmail')->default(true);
            
            // New Product Updates
            $table->boolean('productUpdatesWeb')->default(true);
            $table->boolean('productUpdatesEmail')->default(true);
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
            $table->dropColumn('productSubscribedEmail');
            $table->dropColumn('productSubscribedWeb');
            $table->dropColumn('productUpdatesWeb');
            $table->dropColumn('productUpdatesEmail');
        });
    }
}
