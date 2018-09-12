<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('animal_id')->unsigned();
            $table->integer('animaltype_id')->unsigned();
            $table->integer('breed_id')->unsigned();
            $table->date('datesold');
            $table->string('weight')->nullable();
            $table->string('price')->nullable();
            $table->string('age')->nullable();
            $table->timestamps();
        });

        Schema::table('sales', function($table) {
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
        Schema::dropIfExists('sales');
    }
}
