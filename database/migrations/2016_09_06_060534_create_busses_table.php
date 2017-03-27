<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBussesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('busses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ja');
            $table->string('name_en');
            $table->string('hex_color_code');
            $table->integer('interval_time');
            $table->tinyInteger('saerch_priority')->default(1);
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
        Schema::drop('busses');
    }
}
