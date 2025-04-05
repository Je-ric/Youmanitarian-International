<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('content', function (Blueprint $table) {
            $table->unsignedBigInteger('request_id')->nullable()->after('created_by');
            $table->foreign('request_id')->references('id')->on('content_requests')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('content', function (Blueprint $table) {
            $table->dropForeign(['request_id']);
            $table->dropColumn('request_id');
        });
    }
};
