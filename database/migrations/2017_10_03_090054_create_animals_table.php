<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('animaltype_id')->unsigned();
            $table->string('registryid')->nullable();
            $table->integer('farm_id')->unsigned();
            $table->integer('breed_id')->unsigned();
            $table->boolean('grossmorpho')->default(false);
            $table->boolean('morphochars')->default(false);
            $table->boolean('weightrecord')->default(false);
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('animals', function($table) {
            $table->foreign('animaltype_id')->references('id')->on('animal_types');
            $table->foreign('farm_id')->references('id')->on('farms');
            $table->foreign('breed_id')->references('id')->on('breeds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}
