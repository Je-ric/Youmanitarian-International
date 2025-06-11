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
        Schema::create('program_feedback', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('volunteer_id')->nullable(); // nullable for guests
            $table->string('guest_name')->nullable(); // for guests
            $table->string('guest_email')->nullable(); // optional, for guests
            $table->enum('user_type', ['volunteer', 'guest'])->default('guest');

            $table->tinyInteger('rating')->unsigned()->comment('1 to 5 stars');
            $table->text('feedback')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');

            $table->index(['program_id', 'volunteer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_feedback');
    }
};
