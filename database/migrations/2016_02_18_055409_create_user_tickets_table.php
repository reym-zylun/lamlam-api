<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('ticket_id');
            $table->integer('adult_num');
            $table->integer('child_num');
            $table->datetime('started_date')->nullable()->default(null);
            $table->datetime('expired_date')->nullable()->default(null);
            $table->datetime('purchase_date')->nullable()->default(null);
            $table->datetime('received_date')->nullable()->default(null);
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
        Schema::drop('user_tickets');
    }
}
