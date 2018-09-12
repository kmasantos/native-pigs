<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMortalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mortalities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('animal_id')->unsigned();
            $table->integer('animaltype_id')->unsigned();
            $table->integer('breed_id')->unsigned();
            $table->date('datedied');
            $table->string('cause')->nullable();
            $table->string('age')->nullable();
            $table->timestamps();
        });

        Schema::table('mortalities', function($table) {
            $table->foreign('animal_id')->references('id')->on('animals');
            $table->foreign('animaltype_id')->references('id')->on('animal_types');
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
       Schema::dropIfExists('mortalities');
    }
}
