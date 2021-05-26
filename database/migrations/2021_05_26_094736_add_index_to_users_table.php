<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('id');
            $table->index('username');
            $table->index('firstname');
            $table->index('lastname');
            $table->index('email');
            $table->index('provider');
            $table->index('provider_id');
            $table->index('email_verified_at');
            $table->index('is_staff');
            $table->index('is_contributor');
            $table->index('is_beta');
            $table->index('is_patron');
            $table->index('is_suspended');
            $table->index('spammy');
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
            $table->dropIndex('id');
            $table->dropIndex('username');
            $table->dropIndex('firstname');
            $table->dropIndex('lastname');
            $table->dropIndex('email');
            $table->dropIndex('provider');
            $table->dropIndex('provider_id');
            $table->dropIndex('email_verified_at');
            $table->dropIndex('is_staff');
            $table->dropIndex('is_contributor');
            $table->dropIndex('is_beta');
            $table->dropIndex('is_patron');
            $table->dropIndex('is_suspended');
            $table->dropIndex('spammy');
        });
    }
}
