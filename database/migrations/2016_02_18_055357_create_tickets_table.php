<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ja');
            $table->text('description_ja');
            $table->string('name_en');
            $table->text('description_en');
            $table->string('image_url');
            $table->float('adult_price')->nullable()->default(null);
            $table->float('child_price')->nullable()->default(null);
            $table->String('type');
            $table->integer('duration');
            $table->String('color', 20);
            $table->boolean('recommended')->default(true);
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
        Schema::drop('tickets');
    }
}
