<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivePlayer extends Model
{
    protected $fillable = [
        'player_name',
        'discord_id',
        'license',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
