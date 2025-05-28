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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date')->nullable(); 
            $table->time('start_time')->nullable(); 
            $table->time('end_time')->nullable();
            $table->string('location')->nullable(); 
            $table->enum('progress', ['incoming', 'ongoing', 'done'])->default('incoming');
            $table->integer('volunteer_count')->default(0);

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
