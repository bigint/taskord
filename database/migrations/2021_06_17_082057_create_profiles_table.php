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
            $table->integer('streaks')->default(0);
            $table->string('status')->nullable();
            $table->string('status_emoji')->nullable();
            $table->boolean('hasGoal')->default(true);
            $table->integer('daily_goal')->default(0);
            $table->integer('daily_goal_reached')->default(0);
            $table->boolean('only_followings_tasks')->default(true);
            $table->boolean('check_state')->default(true);
            $table->boolean('isVerified')->default(false);
            $table->boolean('isStaff')->default(false);
            $table->boolean('isDeveloper')->default(false);
            $table->boolean('staffShip')->default(false);
            $table->boolean('darkMode')->default(false);
            $table->boolean('isBeta')->default(false);
            $table->boolean('isPatron')->default(false);
            $table->boolean('isPrivate')->default(false);
            $table->boolean('isFlagged')->default(false);
            $table->boolean('isSuspended')->default(false);
            $table->string('lastIP')->nullable();
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
    }
}
