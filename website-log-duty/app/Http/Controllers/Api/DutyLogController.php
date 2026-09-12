<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DutyLog;
use Illuminate\Http\Request;

class DutyLogController extends Controller
{
    public function index()
    {
        DutyLog::purgeOlderThanWeek();
        $dutyLogs = DutyLog::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $dutyLogs
        ]);
    }

    public function store(Request $request)
    {
        DutyLog::purgeOlderThanWeek();

        $validated = $request->validate([
            'player_name' => 'required|string|max:255',
            'discord_id' => 'nullable|string|max:30',
            'license' => 'nullable|string|max:255',
            'shift' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'total_mingguan' => 'nullable|integer|min:0',
            'status' => 'nullable|in:on_duty,off_duty',
            'discord_message_id' => 'nullable|string|max:30',
        ]);

        $validated['duration'] = $validated['duration'] ?? 0;
        $validated['total_mingguan'] = $validated['total_mingguan'] ?? 0;
        $validated['status'] = $validated['status'] ?? 'off_duty';

        $dutyLog = !empty($validated['discord_message_id'])
            ? DutyLog::updateOrCreate(
                ['discord_message_id' => $validated['discord_message_id']],
                $validated
            )
            : DutyLog::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Duty log berhasil disimpan',
            'data' => $dutyLog
        ], 201);
    }

    public function show($id)
    {
        $dutyLog = DutyLog::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $dutyLog
        ]);
    }
}