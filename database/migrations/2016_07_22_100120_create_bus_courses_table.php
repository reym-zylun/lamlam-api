<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bus_id');
            $table->integer('from_bus_stop_id');
            $table->integer('to_bus_stop_id');
            $table->integer('next_bus_course_id')->nullable()->default(null);
            $table->integer('time');
            $table->text('course');
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
