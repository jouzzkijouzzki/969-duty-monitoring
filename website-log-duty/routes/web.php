<?php

use App\Models\DutyLog;
use App\Models\ActivePlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    DutyLog::purgeOlderThanWindow();

    $logsByDiscordId = DutyLog::query()
        ->whereNotNull('discord_id')
        ->get()
        ->groupBy('discord_id');

    $weeklySummary = ActivePlayer::query()
        ->where('is_active', true)
        ->get()
        ->map(function (ActivePlayer $player) use ($logsByDiscordId) {
            $playerLogs = $logsByDiscordId->get($player->discord_id, collect());
            $latestLog = $playerLogs->sortByDesc('discord_message_id')->first();
            $latestCompletedLog = $playerLogs
                ->filter(fn (DutyLog $log) => $log->end_date || $log->status === 'off_duty')
                ->sortByDesc('discord_message_id')
                ->first() ?: $latestLog;

            return (object) [
                'player_name' => preg_replace('/\s*\([^)]*\)\s*$/', '', $latestCompletedLog?->player_name ?: $player->player_name),
                'discord_id' => $player->discord_id,
                'license' => ($latestCompletedLog?->license ?: $player->license)
                    ? preg_replace('/[*_`]/', '', $latestCompletedLog?->license ?: $player->license)
                    : null,
                'total_mingguan' => (int) ($latestCompletedLog?->total_mingguan ?? 0),
            ];
        })->sortByDesc('total_mingguan')->values();

    $recentHistory = DutyLog::query()
        ->whereNotNull('discord_id')
        ->latest('discord_message_id')
        ->limit(8)
        ->get();

    return view('welcome', [
        'weeklySummary' => $weeklySummary,
        'recentHistory' => $recentHistory,
        'activePlayerCount' => $weeklySummary->count(),
    ]);
})->name('dashboard');

Route::post('/duty-logs/reset', function () {
    $deletedLogs = DutyLog::query()->delete();

    return to_route('dashboard')->with('success', "Reset berhasil. {$deletedLogs} log duty dihapus.");
})->name('duty-logs.reset');

Route::get('/players', function () {
    $registeredDiscordIds = ActivePlayer::query()->pluck('discord_id');
    $candidates = DutyLog::query()
        ->whereNotNull('discord_id')
        ->whereNotIn('discord_id', $registeredDiscordIds)
        ->latest('discord_message_id')
        ->get()
        ->unique('discord_id')
        ->values();

    return view('players', [
        'players' => ActivePlayer::query()->latest()->get(),
        'candidates' => $candidates,
    ]);
})->name('players.index');

Route::get('/logs', function () {
    DutyLog::purgeOlderThanWindow();

    return view('logs', [
        'logs' => DutyLog::query()
            ->latest('created_at')
            ->paginate(50),
    ]);
})->name('logs.index');

Route::post('/players', function (Request $request) {
    $validated = $request->validate([
        'player_name' => ['required', 'string', 'max:255'],
        'discord_id' => ['required', 'string', 'max:30'],
        'license' => ['nullable', 'string', 'max:255'],
    ]);

    ActivePlayer::updateOrCreate(
        ['discord_id' => $validated['discord_id']],
        [...$validated, 'is_active' => true],
    );

    return to_route('players.index')->with('success', 'Player berhasil didaftarkan.');
})->name('players.store');

Route::patch('/players/{player}/deactivate', function (ActivePlayer $player) {
    $player->update(['is_active' => false]);

    return to_route('players.index')->with('success', 'Player dinonaktifkan dari dashboard.');
})->name('players.deactivate');

Route::patch('/players/{player}/activate', function (ActivePlayer $player) {
    $player->update(['is_active' => true]);

    return to_route('players.index')->with('success', 'Player diaktifkan kembali di dashboard.');
})->name('players.activate');