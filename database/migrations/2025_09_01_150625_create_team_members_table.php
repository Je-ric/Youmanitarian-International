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
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            // Optional link to members table
            $table->unsignedBigInteger('member_id')->nullable();

            // (cm can override even if linked to a member)
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('photo_url')->nullable();
            $table->text('bio')->nullable();

            // socials (idk if needed)
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();

            // Display control
            // undecided sa order, magiging drag and drop yung dating
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
