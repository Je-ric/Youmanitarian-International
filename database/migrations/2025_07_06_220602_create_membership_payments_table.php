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
        Schema::create('membership_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->decimal('amount', 10, 2);
            $table->timestamp('payment_date')->useCurrent();
            $table->enum('payment_status', ['paid', 'pending', 'overdue'])->default('pending');
            $table->string('receipt_url')->nullable();
            // $table->enum('payment_method', ['cash', 'bank_transfer', 'paypal'])->default('cash');
            $table->string('payment_method')->default('cash')->nullable();
            $table->enum('payment_period', ['Q1', 'Q2', 'Q3', 'Q4']);
            $table->year('payment_year');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('recorded_by')->nullable();
            $table->timestamps();
        
            $table->foreign('recorded_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('restrict');
            
            // Prevent duplicate payments for the same period
            $table->unique(['member_id', 'payment_period', 'payment_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_payments');
    }
};
