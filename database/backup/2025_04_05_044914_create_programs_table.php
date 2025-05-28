<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->time('start_time')->nullable(); 
            $table->time('end_time')->nullable();
            $table->string('location')->nullable(); 
            $table->enum('progress', ['incoming', 'ongoing', 'done'])->default('incoming');
            $table->integer('volunteer_count')->default(0);

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('programs');
    }
};
