<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('duty_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('duty_logs', 'duration')) {
                $table->integer('duration')->default(0)->after('shift');
            }
            if (!Schema::hasColumn('duty_logs', 'start_date')) {
                $table->dateTime('start_date')->nullable()->after('duration');
            }
            if (!Schema::hasColumn('duty_logs', 'end_date')) {
                $table->dateTime('end_date')->nullable()->after('start_date');
            }
            if (!Schema::hasColumn('duty_logs', 'total_mingguan')) {
                $table->integer('total_mingguan')->default(0)->after('end_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('duty_logs', function (Blueprint $table) {
            foreach (['duration', 'start_date', 'end_date', 'total_mingguan'] as $column) {
                if (Schema::hasColumn('duty_logs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};