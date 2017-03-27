<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', array('charge','refund'))->default('charge');
            $table->string('token')->nullable()->default(null);
            $table->dateTime('expired_date')->nullable()->default(null);
            $table->integer('user_id');
            $table->integer('ticket_id');
            $table->integer('adult_num');
            $table->integer('child_num');
            $table->float('adult_price')->nullable()->default(null);
            $table->float('child_price')->nullable()->default(null);
            $table->integer('user_ticket_id')->nullable()->default(null);
            $table->float('amount');
            $table->dateTime('payment_date')->nullable()->default(null);
            $table->string('transaction_id', 20)->nullable()->default(null);
            $table->tinyInteger('transaction_response_code')->nullable()->default(null);
            $table->text('api_response')->nullable();
            $table->string('customer_payment_profile_id', 20)->nullable()->default(null);
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
        Schema::drop('payments');
    }
}
