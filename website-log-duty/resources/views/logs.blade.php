<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>969 Resto | Database Logs</title>
    <style>
        :root { --blue: #2878e5; --blue-soft: #e9f2ff; --ink: #303846; --muted: #8a94a6; --line: #edf0f4; --page: #f7f9fc; }
        * { box-sizing: border-box; }
        body { margin: 0; background: linear-gradient(135deg, #eef5ff 0%, #f7f9fc 48%, #e8f1ff 100%); color: var(--ink); font-family: "Segoe UI", Arial, sans-serif; }
        a { color: inherit; text-decoration: none; }
        .app { display: grid; grid-template-columns: 190px minmax(0, 1fr); min-height: 100vh; }
        .sidebar { padding: 28px 22px; background: #fff; border-right: 1px solid var(--line); }
        .brand { display: flex; align-items: center; gap: 10px; margin: 0 10px 58px; font-size: 16px; font-weight: 700; }
        .brand-logo { width: 34px; height: 34px; object-fit: contain; }
        .nav { display: grid; gap: 10px; }
        .nav a { display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 7px; color: #98a2b3; font-size: 13px; }
        .nav a:hover, .nav a.active { color: var(--blue); background: var(--blue-soft); }
        .nav-icon { width: 17px; text-align: center; font-size: 16px; }
        .main { min-width: 0; padding: 36px 32px 45px; }
        .topline { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
        .topline h1 { margin: 0; font-size: 18px; }
        .top-logo { width: 46px; height: 46px; object-fit: contain; }
        .intro { display: flex; justify-content: space-between; align-items: end; gap: 20px; margin-bottom: 23px; }
        .intro h2 { margin: 0 0 6px; color: #244d86; font-size: 30px; font-weight: 500; }
        .intro p { margin: 0; color: var(--muted); font-size: 14px; }
        .back { color: var(--blue); font-size: 14px; font-weight: 700; }
        .panel { overflow: hidden; background: rgba(255, 255, 255, .9); border: 1px solid #dce9fb; border-radius: 8px; box-shadow: 0 9px 26px rgba(39, 61, 92, .1); }
        .panel-head { padding: 22px 26px 17px; border-bottom: 1px solid #dce9fb; background: linear-gradient(100deg, #edf5ff, #f8fbff); }
        .panel-head h3 { margin: 0 0 6px; color: #244d86; font-size: 17px; }
        .panel-head p { margin: 0; color: var(--muted); font-size: 13px; }
        .table-wrap { overflow-x: auto; padding: 0 26px 18px; }
        table { width: 100%; border-collapse: collapse; min-width: 900px; }
        th { padding: 15px 12px 11px 0; color: #6e7888; font-size: 11px; font-weight: 700; text-align: left; text-transform: uppercase; }
        td { padding: 14px 12px 14px 0; border-top: 1px solid var(--line); color: #566173; font-size: 13px; vertical-align: top; }
        .player { color: #3f4856; font-weight: 700; }
        .mono { color: #647084; font-family: monospace; font-size: 12px; }
        .date { white-space: nowrap; }
        .status { display: inline-block; padding: 4px 8px; border-radius: 5px; font-size: 10px; font-weight: 700; }
        .on { color: #15803d; background: #dcfce7; }
        .off { color: #b42318; background: #fee4e2; }
        .empty { padding: 42px 20px; color: var(--muted); text-align: center; font-size: 13px; }
        .pagination { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 18px 26px 24px; color: var(--muted); font-size: 12px; }
        .pagination-links { display: flex; gap: 6px; flex-wrap: wrap; }
        .pagination a, .pagination span { padding: 7px 10px; border: 1px solid #dce9fb; border-radius: 5px; }
        .pagination a { color: var(--blue); background: #f7fbff; }
        .pagination .current { color: #fff; background: var(--blue); border-color: var(--blue); }
        .footer { margin-top: 24px; color: #a0a8b5; font-size: 11px; text-align: center; }
        @media (max-width: 700px) { .app { display: block; } .sidebar { padding: 16px; border-right: 0; border-bottom: 1px solid var(--line); } .brand { margin: 0 0 15px; } .nav { display: flex; overflow-x: auto; gap: 4px; } .nav a { white-space: nowrap; } .main { padding: 24px 16px 36px; } .intro { align-items: start; flex-direction: column; } }
    </style>
</head>
<body>
    <div class="app">
        <aside class="sidebar">
            <div class="brand"><img class="brand-logo" src="{{ asset('969restologo2.png') }}" alt="969 Resto"><span>969 RESTO</span></div>
            <nav class="nav">
                <a href="{{ url('/') }}"><span class="nav-icon">⌂</span>Home</a>
                <a href="{{ url('/') }}"><span class="nav-icon">ϟ</span>Duty Log</a>
                <a class="active" href="{{ route('logs.index') }}"><span class="nav-icon">▤</span>Database Logs</a>
                <a href="{{ route('players.index') }}"><span class="nav-icon">◉</span>Member</a>
            </nav>
        </aside>
        <main class="main">
            <div class="topline"><h1>969 RESTO</h1><img class="top-logo" src="{{ asset('969restologo2.png') }}" alt="969 Resto"></div>
            <div class="intro"><div><h2>Database Logs</h2><p>Data duty yang diterima dari Discord bot dalam 8 hari terakhir.</p></div><a class="back" href="{{ url('/') }}">Kembali ke Dashboard</a></div>
            <section class="panel">
                <div class="panel-head"><h3>Log Duty Discord</h3><p>{{ $logs->total() }} log tersimpan di database.</p></div>
                @if($logs->isEmpty())
                    <div class="empty">Belum ada data duty dari Discord bot.</div>
                @else
                    <div class="table-wrap"><table><thead><tr><th>Player</th><th>Status</th><th>Mulai</th><th>Selesai</th><th>Durasi</th><th>Total Mingguan</th><th>Discord Message ID</th><th>Dicatat</th></tr></thead><tbody>
                        @foreach($logs as $log)
                            @php
                                $formatMinutes = function ($minutes) { return intdiv((int) $minutes, 60) . ' jam ' . ((int) $minutes % 60) . ' menit'; };
                            @endphp
                            <tr>
                                <td class="player">{{ $log->player_name }}</td>
                                <td><span class="status {{ $log->status === 'on_duty' ? 'on' : 'off' }}">{{ $log->status === 'on_duty' ? 'On Duty' : 'Off Duty' }}</span></td>
                                <td class="date">{{ optional($log->start_date)->format('d M Y H:i') ?: '-' }}</td>
                                <td class="date">{{ optional($log->end_date)->format('d M Y H:i') ?: '-' }}</td>
                                <td>{{ $formatMinutes($log->duration) }}</td>
                                <td>{{ $formatMinutes($log->total_mingguan) }}</td>
                                <td class="mono">{{ $log->discord_message_id ?: '-' }}</td>
                                <td class="date">{{ optional($log->created_at)->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody></table></div>
                    <div class="pagination"><span>Menampilkan {{ $logs->firstItem() }}-{{ $logs->lastItem() }} dari {{ $logs->total() }} log</span><div class="pagination-links">@if($logs->onFirstPage())<span>Sebelumnya</span>@else<a href="{{ $logs->previousPageUrl() }}">Sebelumnya</a>@endif @foreach($logs->getUrlRange(max(1, $logs->currentPage() - 2), min($logs->lastPage(), $logs->currentPage() + 2)) as $page => $url) @if($page == $logs->currentPage())<span class="current">{{ $page }}</span>@else<a href="{{ $url }}">{{ $page }}</a>@endif @endforeach @if($logs->hasMorePages())<a href="{{ $logs->nextPageUrl() }}">Berikutnya</a>@else<span>Berikutnya</span>@endif</div></div>
                @endif
            </section>
            <div class="footer">969 Duty Monitoring &copy; {{ date('Y') }}</div>
        </main>
    </div>
</body>
</html>
