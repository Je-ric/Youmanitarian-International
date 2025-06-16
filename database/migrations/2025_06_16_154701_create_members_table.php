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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); 
            $table->unsignedBigInteger('volunteer_id')->unique();
            $table->enum('membership_type', ['full_pledge', 'honorary'])->default('full_pledge'); 
            $table->timestamp('start_date')->useCurrent();
            $table->timestamp('end_date')->nullable(); 
            $table->enum('membership_status', ['active', 'inactive'])->default('inactive');
            $table->boolean('board_invited')->default(false); 
            $table->timestamp('became_member_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
}; 