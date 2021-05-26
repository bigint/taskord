<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->index('id');
            $table->index('user_id');
            $table->index('product_id');
            $table->index('milestone_id');
            $table->index('source');
            $table->index('hidden');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex('id');
            $table->dropIndex('user_id');
            $table->dropIndex('product_id');
            $table->dropIndex('milestone_id');
            $table->dropIndex('source');
            $table->dropIndex('hidden');
        });
    }
}
