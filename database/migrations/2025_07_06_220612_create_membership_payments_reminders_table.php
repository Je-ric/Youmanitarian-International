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
        Schema::create('membership_payments_reminders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('membership_payment_id');
            $table->unsignedBigInteger('sent_by_user_id')->nullable();
            $table->string('status'); // sent, failed
            $table->text('content'); // The reminder message
            $table->timestamps();

            $table->foreign('membership_payment_id')
                    ->references('id')
                    ->on('membership_payments')
                    ->onDelete('cascade');
            
            $table->foreign('sent_by_user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_payments_reminders');
    }
}; 