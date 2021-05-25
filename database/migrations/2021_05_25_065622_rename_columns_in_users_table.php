<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('onlyFollowingsTasks', 'only_followings_tasks');
            $table->renameColumn('checkState', 'check_state');
            $table->renameColumn('isStaff', 'is_staff');
            $table->renameColumn('isDeveloper', 'is_contributor');
            $table->renameColumn('staffShip', 'staff_mode');
            $table->renameColumn('darkMode', 'dark_mode');
            $table->renameColumn('isBeta', 'is_beta');
            $table->renameColumn('isPatron', 'is_patron');
            $table->renameColumn('isPrivate', 'is_private');
            $table->renameColumn('isVerified', 'is_verified');
            $table->renameColumn('isFlagged', 'spammy');
            $table->renameColumn('isSuspended', 'is_suspended');
            $table->renameColumn('lastIP', 'last_ip');
            $table->renameColumn('hasGoal', 'has_goal');
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
            $table->renameColumn('only_followings_tasks', 'onlyFollowingsTasks');
            $table->renameColumn('check_state', 'checkState');
            $table->renameColumn('is_staff', 'isStaff');
            $table->renameColumn('is_contributor', 'isDeveloper');
            $table->renameColumn('staff_mode', 'staffShip');
            $table->renameColumn('dark_mode', 'darkMode');
            $table->renameColumn('is_beta', 'isBeta');
            $table->renameColumn('is_patron', 'isPatron');
            $table->renameColumn('is_private', 'isPrivate');
            $table->renameColumn('is_verified', 'isVerified');
            $table->renameColumn('spammy', 'isFlagged');
            $table->renameColumn('is_suspended', 'isSuspended');
            $table->renameColumn('last_ip', 'lastIP');
            $table->renameColumn('has_goal', 'hasGoal');
        });
    }
}
