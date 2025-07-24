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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longtext('body');
            $table->string('image_content')->nullable();
            $table->enum('content_status', ['draft', 'published', 'archived'])->default('draft');
            $table->enum('content_type', ['news', 'program','announcement','event','article','blog'])->default('news')->index();
            $table->enum('approval_status', ['draft', 'submitted', 'pending', 'approved', 'rejected', 'needs_revision'])->default('draft');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('slug')->unique();
            $table->integer('views')->default(0);
            $table->boolean('enable_likes')->default(true);
            $table->boolean('enable_comments')->default(true);
            $table->boolean('enable_bookmark')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            $table->index('content_status');
            $table->index('approval_status');
            $table->index('created_by');

            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
