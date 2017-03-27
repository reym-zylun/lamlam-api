<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuedTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issued_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', array('registration','split','campaign'))->default('registration');
            $table->string('receive_key');
            $table->integer('ticket_id');
            $table->integer('adult_num');
            $table->integer('child_num');
            $table->datetime('started_date')->nullable()->default(null);
            $table->datetime('expired_date')->nullable()->default(null);
            $table->datetime('purchase_date')->nullable()->default(null);
            $table->datetime('issued_date');
            $table->integer('user_ticket_id')->nullable()->default(null);
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
        //
    }
}
