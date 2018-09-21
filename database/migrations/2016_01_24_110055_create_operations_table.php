<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->integer('tooth_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->float('price')->default(0.0);
            $table->text('notice');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patients');

            $table->foreign('tooth_id')
                  ->references('id')
                  ->on('teeth');

            $table->foreign('type_id')
                  ->references('id')
                  ->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('operations');
    }
}
