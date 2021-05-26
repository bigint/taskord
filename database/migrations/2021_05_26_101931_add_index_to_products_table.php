<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index('id');
            $table->index('user_id');
            $table->index('slug');
            $table->index('name');
            $table->index('launched');
            $table->index('launched_at');
            $table->index('deprecated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('id');
            $table->dropIndex('user_id');
            $table->dropIndex('slug');
            $table->dropIndex('name');
            $table->dropIndex('launched');
            $table->dropIndex('launched_at');
            $table->dropIndex('deprecated');
        });
    }
}
