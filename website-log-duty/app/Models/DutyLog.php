<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DutyLog extends Model
{
    protected $table = 'duty_logs';

    protected $fillable = [
        'player_name',
        'discord_id',
        'license',
        'shift',
        'duration',
        'start_date',
        'end_date',
        'total_mingguan',
        'status',
        'discord_message_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public static function purgeOlderThanWeek(): int
    {
        return static::query()
            ->where('created_at', '<', now()->subDays(7))
            ->delete();
    }
}