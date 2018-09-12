<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemovedAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('removed_animals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('animal_id')->unsigned();
            $table->integer('animaltype_id')->unsigned();
            $table->integer('breed_id')->unsigned();
            $table->date('dateremoved');
            $table->string('reason')->nullable();
            $table->string('age')->nullable();
            $table->timestamps();
        });

        Schema::table('removed_animals', function($table) {
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
        Schema::dropIfExists('removed_animals');
    }
}
