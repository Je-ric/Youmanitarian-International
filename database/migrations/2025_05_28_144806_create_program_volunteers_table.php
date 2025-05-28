<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('program_volunteers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('volunteer_id');
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending');
            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_volunteers');
    }
};
