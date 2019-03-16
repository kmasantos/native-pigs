<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('animal_id')->unsigned()->nullable();
            $table->integer('animaltype_id')->unsigned()->nullable();
            $table->integer('breed_id')->unsigned()->nullable();
            $table->string('filename')->nullable();
            $table->timestamps();
        });

         Schema::table('uploads', function($table) {
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
        Schema::dropIfExists('uploads');
    }
}
