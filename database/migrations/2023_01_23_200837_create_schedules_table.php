<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string("name", 256);
            $table->string("cpf", 11)->unique();
            $table->string("card_sus", 15)->unique();
            $table->string("reason", 256);
            $table->timestamp("date_scheduling");
            $table->enum("urgency", ["baixa","media","alta","urgente"]);
            $table->string("doctor_name", 256);
            $table->string("professional_name", 256);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
