<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('company')->nullable();
            $table->string('website')->nullable();
            $table->string('twitter')->nullable();
            $table->string('twitch')->nullable();
            $table->string('github')->nullable();
            $table->string('telegram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('sponsor')->nullable();
            $table->integer('streaks')->default(false);
            $table->string('timezone')->nullable();
            $table->string('status')->nullable();
            $table->string('status_emoji')->nullable();
            $table->boolean('has_goal')->default(true);
            $table->integer('daily_goal')->default(5)->change();
            $table->integer('daily_goal_reached')->default(false);
            $table->boolean('vacation_mode')->default(false);
            $table->boolean('only_followings_tasks')->default(true);
            $table->boolean('check_state')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_staff')->default(false);
            $table->boolean('is_contributor')->default(false);
            $table->boolean('staff_mode')->default(false);
            $table->boolean('is_beta')->default(false);
            $table->boolean('is_patron')->default(false);
            $table->boolean('is_private')->default(false);
            $table->boolean('spammy')->default(false);
            $table->boolean('is_suspended')->default(false);
            $table->longText('staff_notes')->nullable();
            $table->string('last_ip')->nullable();
            $table->dateTime('last_active')->nullable();
            $table->string('api_token', 80)->unique()->nullable()->default(null);
            $table->boolean('notifications_email')->default(true);
            $table->boolean('notifications_web')->default(true);
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
        Schema::dropIfExists('profiles');
        Schema::table('webhooks', function (Blueprint $table) {
            $table->dropIndex('firstname');
            $table->dropIndex('lastname');
            $table->dropIndex('is_staff');
            $table->dropIndex('is_contributor');
            $table->dropIndex('is_beta');
            $table->dropIndex('is_patron');
            $table->dropIndex('is_suspended');
            $table->dropIndex('spammy');

            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            $table->dropColumn('avatar');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
            $table->dropColumn('txt_code');
        });
    }
}
