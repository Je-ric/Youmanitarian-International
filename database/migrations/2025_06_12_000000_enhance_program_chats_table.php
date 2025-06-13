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
        Schema::table('program_chats', function (Blueprint $table) {
            // Add message type to distinguish between regular messages, announcements, etc.
            $table->enum('message_type', ['regular', 'announcement', 'system'])->default('regular')->after('message');
            
            // Add parent_id for reply threads
            $table->unsignedBigInteger('parent_id')->nullable()->after('sender_id');
            $table->foreign('parent_id')->references('id')->on('program_chats')->onDelete('cascade');
            
            // Add is_pinned flag for important messages
            $table->boolean('is_pinned')->default(false)->after('message_type');
            
            // Add is_edited flag to track edited messages
            $table->boolean('is_edited')->default(false)->after('is_pinned');
            
            // Add edited_at timestamp
            $table->timestamp('edited_at')->nullable()->after('is_edited');
            
            // Add soft deletes for message deletion
            $table->softDeletes();
        });

        // Create a table to track read messages
        Schema::create('program_chat_reads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('read_at')->useCurrent();
            $table->timestamps();

            $table->foreign('chat_id')->references('id')->on('program_chats')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Prevent duplicate read records
            $table->unique(['chat_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_chat_reads');
        
        Schema::table('program_chats', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('edited_at');
            $table->dropColumn('is_edited');
            $table->dropColumn('is_pinned');
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
            $table->dropColumn('message_type');
        });
    }
}; 