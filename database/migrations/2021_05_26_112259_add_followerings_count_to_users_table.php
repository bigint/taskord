<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFolloweringsCountToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->mediumInteger('following_count')->default(0);
            $table->mediumInteger('followers_count')->default(0);
            $table->index('following_count');
            $table->index('followers_count');
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
            $table->dropColumn('following_count');
            $table->dropColumn('followers_count');
            $table->dropIndex('following_count');
            $table->dropIndex('followers_count');
        });
    }
}
