<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('duty_logs', function (Blueprint $table) {
            $table->string('discord_message_id', 30)->nullable()->unique()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('duty_logs', function (Blueprint $table) {
            $table->dropUnique(['discord_message_id']);
            $table->dropColumn('discord_message_id');
        });
    }
};