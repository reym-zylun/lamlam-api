<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSplitHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('split_histories', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_ticket_id');
            $table->integer('adult_num');
            $table->integer('child_num');
            $table->datetime('splitted_date');
            $table->integer('issued_ticket_id');
            $table->boolean('valid')->default(true);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('split_histories');
    }
}
