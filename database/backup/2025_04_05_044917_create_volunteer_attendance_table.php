<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('volunteer_attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('volunteer_id');
            $table->unsignedBigInteger('program_id');
            $table->dateTime('clock_in')->nullable();
            $table->dateTime('clock_out')->nullable();
            $table->integer('hours_logged')->default(0);
            $table->timestamps();

            $table->foreign('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_attendance');
    }
};
