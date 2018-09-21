<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIllnessPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('illness_patients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->integer('illness_id')->unsigned();
            $table->text('notice');
            $table->timestamps();


            $table->foreign('patient_id')
                ->references('id')
                ->on('patients');

            $table->foreign('illness_id')
                ->references('id')
                ->on('illnesses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('illness_patients');
    }
}
