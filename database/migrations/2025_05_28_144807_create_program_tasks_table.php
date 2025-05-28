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
        Schema::create('program_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->text('task_description');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_tasks');
    }
};
