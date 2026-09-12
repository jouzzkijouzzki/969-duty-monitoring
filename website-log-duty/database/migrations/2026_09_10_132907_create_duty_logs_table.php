<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('duty_logs', function (Blueprint $table) {
        $table->id();
        $table->string('player_name');
        $table->string('discord_id')->nullable();
        $table->string('license')->nullable();
        $table->string('shift')->nullable();
        $table->integer('duration')->default(0);
        $table->dateTime('start_date')->nullable();
        $table->dateTime('end_date')->nullable();
        $table->integer('total_mingguan')->default(0);
        $table->enum('status', ['on_duty', 'off_duty'])->default('off_duty');
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('duty_logs');
    }
};