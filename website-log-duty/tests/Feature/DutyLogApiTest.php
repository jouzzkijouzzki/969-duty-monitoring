<?php

namespace Tests\Feature;

use App\Models\DutyLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DutyLogApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_discord_payload_is_saved_and_returned(): void
    {
        $payload = [
            'player_name' => 'Budi',
            'discord_id' => '123456789012345678',
            'license' => 'license:abc',
            'shift' => 'Pagi',
            'duration' => 90,
            'start_date' => '2026-09-11 08:00:00',
            'end_date' => '2026-09-11 09:30:00',
            'total_mingguan' => 420,
            'status' => 'off_duty',
            'discord_message_id' => '1234567890123456789',
        ];

        $this->postJson('/api/duty-logs', $payload)
            ->assertCreated()
            ->assertJsonPath('data.player_name', 'Budi')
            ->assertJsonPath('data.duration', 90);

        $this->assertDatabaseHas('duty_logs', [
            'discord_message_id' => $payload['discord_message_id'],
            'player_name' => 'Budi',
            'duration' => 90,
        ]);

        $this->getJson('/api/duty-logs')
            ->assertOk()
            ->assertJsonPath('data.0.discord_id', '123456789012345678');
    }

    public function test_same_discord_message_updates_existing_log(): void
    {
        $log = DutyLog::create([
            'player_name' => 'Budi',
            'discord_message_id' => '1234567890123456789',
            'status' => 'on_duty',
        ]);

        $this->postJson('/api/duty-logs', [
            'player_name' => 'Budi',
            'duration' => 60,
            'status' => 'off_duty',
            'discord_message_id' => $log->discord_message_id,
        ])->assertCreated();

        $this->assertSame(1, DutyLog::where('discord_message_id', $log->discord_message_id)->count());
        $this->assertDatabaseHas('duty_logs', [
            'id' => $log->id,
            'duration' => 60,
            'status' => 'off_duty',
        ]);
    }

    public function test_logs_older_than_seven_days_are_purged_when_a_log_is_stored(): void
    {
        $oldLog = DutyLog::create([
            'player_name' => 'Old log',
            'discord_message_id' => 'old-log-123',
        ]);
        $oldLog->created_at = now()->subDays(8);
        $oldLog->saveQuietly();

        $this->postJson('/api/duty-logs', [
            'player_name' => 'New log',
            'discord_message_id' => 'new-log-123',
        ])->assertCreated();

        $this->assertDatabaseMissing('duty_logs', ['id' => $oldLog->id]);
        $this->assertDatabaseHas('duty_logs', ['discord_message_id' => 'new-log-123']);
    }

    public function test_dashboard_reset_deletes_all_duty_logs(): void
    {
        DutyLog::create(['player_name' => 'Budi']);
        DutyLog::create(['player_name' => 'Sari']);

        $this->post('/duty-logs/reset')
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseCount('duty_logs', 0);
    }
}