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
        Schema::create('program_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('email')->nullable();     
            $table->string('contact_number')->nullable();

            $table->text('description');
            $table->string('target_audience');
            $table->string('location');
            $table->date('proposed_date')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])
                    ->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_requests');
    }
};
