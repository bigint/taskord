<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webhooks', function (Blueprint $table) {
            $table->index('id');
            $table->index('user_id');
            $table->index('product_id');
            $table->index('token');
            $table->index('name');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webhooks', function (Blueprint $table) {
            $table->dropIndex('id');
            $table->dropIndex('user_id');
            $table->dropIndex('product_id');
            $table->dropIndex('token');
            $table->dropIndex('name');
            $table->dropIndex('type');
        });
    }
}
