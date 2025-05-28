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
        Schema::create('volunteer_application', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('volunteer_id'); 
        
            $table->string('why_volunteer', 500)->nullable(); 
            $table->string('interested_programs', 255)->nullable();
            $table->string('skills_experience', 255)->nullable();
            $table->string('availability', 255)->nullable();
            $table->string('commitment_hours', 255)->nullable();
            $table->string('physical_limitations', 255)->nullable();
            $table->string('emergency_contact', 255)->nullable();
            $table->enum('contact_consent', ['yes', 'no']);
            $table->enum('volunteered_before', ['yes', 'no']);
            $table->enum('outdoor_ok', ['yes', 'no', 'depends']);
            $table->string('short_bio', 500)->nullable();
        
            $table->boolean('is_active')->default(true); 
            $table->timestamp('submitted_at')->nullable(); 
        
            $table->foreign('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_application');
    }
};
