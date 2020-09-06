<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->unique();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
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
            $table->boolean('onlyFollowingsTasks')->default(false);
            $table->boolean('checkState')->default(true);
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
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
