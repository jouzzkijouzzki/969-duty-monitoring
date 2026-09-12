<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>969 Resto | Duty Log</title>
    <style>
        :root { --blue: #2878e5; --blue-soft: #e9f2ff; --ink: #303846; --muted: #8a94a6; --line: #edf0f4; --page: #f7f9fc; }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--page); color: var(--ink); font-family: "Segoe UI", Arial, sans-serif; }
        a { color: inherit; text-decoration: none; }
        .app { display: grid; grid-template-columns: 190px minmax(0, 1fr) 265px; min-height: 100vh; }
        .sidebar { padding: 28px 22px; background: #fff; border-right: 1px solid var(--line); }
        .brand { display: flex; align-items: center; gap: 10px; margin: 0 10px 58px; font-size: 16px; font-weight: 700; }
        .brand-logo { width: 34px; height: 34px; object-fit: contain; }
        .nav { display: grid; gap: 10px; }
        .nav a { display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 7px; color: #98a2b3; font-size: 13px; transition: color .2s ease, background-color .2s ease, transform .2s ease; }
        .nav a.active, .nav a:hover { color: var(--blue); background: var(--blue-soft); }
        .nav a:hover { transform: translateX(3px); }
        .nav-icon { width: 17px; text-align: center; font-size: 16px; }
        .main { min-width: 0; padding: 36px 32px 45px; }
        .topline { display: flex; justify-content: space-between; align-items: center; margin-bottom: 27px; }
        .topline-actions { display: flex; align-items: center; gap: 14px; }
        .topline h1 { margin: 0; font-size: 18px; font-weight: 700; }
        .online { color: #7f8a9c; font-size: 14px; }
        .online-dot { display: inline-block; width: 7px; height: 7px; margin-right: 6px; border-radius: 50%; background: #2fbd78; }
        .top-logo { width: 46px; height: 46px; object-fit: contain; }
        .theme-toggle { border: 1px solid #d5e3f7; border-radius: 6px; padding: 8px 11px; color: #315d93; background: #fff; font-size: 12px; cursor: pointer; transition: color .2s ease, background-color .2s ease, border-color .2s ease, transform .2s ease; }
        .theme-toggle:hover { border-color: var(--blue); color: var(--blue); transform: translateY(-2px); }
        .theme-toggle:focus-visible, .nav a:focus-visible, .empty a:focus-visible { outline: 3px solid rgba(40, 120, 229, .28); outline-offset: 2px; }
        .panel-head-actions { display: flex; align-items: center; gap: 12px; }
        .view-all { border: 1px solid #c9def9; border-radius: 6px; padding: 7px 10px; color: var(--blue); background: #f7fbff; font-size: 12px; cursor: pointer; transition: color .2s ease, background-color .2s ease, border-color .2s ease, transform .2s ease; }
        .view-all:hover { border-color: var(--blue); background: var(--blue-soft); transform: translateY(-2px); }
        .view-all:focus-visible { outline: 3px solid rgba(40, 120, 229, .28); outline-offset: 2px; }
        .cards { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; margin-bottom: 28px; }
        .card { display: flex; align-items: center; gap: 17px; min-height: 90px; padding: 17px; background: #fff; border-radius: 8px; box-shadow: 0 9px 26px rgba(39, 61, 92, .08); transition: transform .2s ease, box-shadow .2s ease; }
        .card:hover { transform: translateY(-3px); box-shadow: 0 14px 30px rgba(39, 61, 92, .14); }
        .card-icon { display: grid; place-items: center; width: 34px; height: 34px; border-radius: 5px; background: #eef0f2; color: #677386; }
        .card-label { margin-bottom: 8px; color: var(--ink); font-size: 15px; font-weight: 700; }
        .card-value { color: #657083; font-size: 14px; }
        .panel { background: #fff; border-radius: 8px; box-shadow: 0 9px 26px rgba(39, 61, 92, .08); overflow: hidden; }
        .below-panels { display: grid; grid-template-columns: minmax(0, 1.15fr) minmax(260px, .85fr); gap: 18px; margin-top: 18px; }
        .panel-head { display: flex; justify-content: space-between; align-items: end; padding: 26px 34px 17px; }
        .eyebrow { margin-bottom: 7px; font-size: 13px; font-weight: 700; }
        .panel-head h2 { margin: 0; font-size: 30px; font-weight: 500; }
        .panel-head span { color: #6c7687; font-size: 14px; }
        .table-wrap { overflow-x: auto; padding: 0 34px 20px; }
        .duty-table-wrap { max-height: 360px; overflow-y: auto; scrollbar-color: #a9c8ed transparent; scrollbar-width: thin; }
        .duty-table-wrap.expanded { max-height: none; }
        table { width: 100%; border-collapse: collapse; min-width: 480px; }
        th { padding: 0 0 12px; color: #6e7888; font-size: 13px; font-weight: 400; text-align: left; }
        td { padding: 14px 0; border-top: 1px solid var(--line); color: #566173; font-size: 14px; transition: background-color .2s ease; }
        tbody tr { transition: transform .2s ease; }
        tbody tr:hover { transform: translateX(4px); }
        tbody tr:hover td { background: rgba(40, 120, 229, .045); }
        .player-cell { display: flex; align-items: center; gap: 11px; min-width: 0; }
        .player-avatar { display: grid; place-items: center; flex: 0 0 32px; width: 32px; height: 32px; border-radius: 9px; color: #fff; background: linear-gradient(145deg, #2878e5, #64a5f5); font-size: 11px; font-weight: 800; }
        .player { display: block; max-width: 300px; overflow: hidden; color: #3f4856; font-weight: 600; text-overflow: ellipsis; white-space: nowrap; }
        .license { color: #647084; font-family: monospace; font-size: 13px; }
        .total { color: #3f4856; white-space: nowrap; font-weight: 600; }
        .ranking-panel { padding-bottom: 8px; }
        .ranking-list { display: grid; gap: 8px; padding: 0 24px 18px; }
        .ranking-item { display: grid; grid-template-columns: 34px minmax(0, 1fr) auto; align-items: center; gap: 12px; padding: 11px 12px; border: 1px solid var(--line); border-radius: 8px; transition: transform .2s ease, border-color .2s ease, background-color .2s ease; }
        .ranking-item:hover { border-color: #b9d5f7; background: #f7fbff; transform: translateX(3px); }
        .ranking-number { display: grid; place-items: center; width: 28px; height: 28px; border-radius: 50%; color: #fff; background: #8da3bd; font-size: 12px; font-weight: 800; }
        .ranking-item:first-child .ranking-number { background: #e0a92d; }
        .ranking-item:nth-child(2) .ranking-number { background: #8192a8; }
        .ranking-item:nth-child(3) .ranking-number { background: #b9794b; }
        .ranking-name { overflow: hidden; color: #3f4856; font-size: 13px; font-weight: 600; text-overflow: ellipsis; white-space: nowrap; }
        .ranking-time { color: #657083; font-size: 12px; font-weight: 700; white-space: nowrap; }
        .about-panel { padding: 24px; background: linear-gradient(145deg, #edf5ff, #fff); }
        .about-panel h3 { margin: 0 0 10px; color: #244d86; font-size: 18px; }
        .about-panel p { margin: 0; color: #657083; font-size: 13px; line-height: 1.7; }
        .empty { padding: 38px 20px; color: var(--muted); text-align: center; font-size: 13px; }
        .empty a { display: inline-block; margin-top: 14px; padding: 9px 13px; border-radius: 5px; color: #fff; background: var(--blue); font-weight: 700; }
        .history { padding: 36px 24px; background: #fff; border-left: 1px solid var(--line); }
        .history h2 { margin: 0 0 29px; font-size: 17px; }
        .history-list { position: relative; display: grid; gap: 25px; }
        .history-list::before { content: ''; position: absolute; top: 4px; bottom: 4px; left: 10px; border-left: 1px dashed #d7dde7; }
        .history-item { position: relative; display: grid; grid-template-columns: 22px 1fr; gap: 10px; }
        .history-item { transition: transform .2s ease; }
        .history-item:hover { transform: translateX(3px); }
        .history-icon { z-index: 1; display: grid; place-items: center; width: 21px; height: 21px; border: 1px solid #d8dee8; border-radius: 50%; color: var(--blue); background: #fff; font-size: 10px; }
        .history-name { display: block; max-width: 190px; margin: 1px 0 5px; overflow: hidden; color: var(--blue); font-size: 14px; line-height: 1.35; text-overflow: ellipsis; white-space: nowrap; }
        .history-time { color: #a0a8b5; font-size: 12px; }
        .history-status { display: inline-block; margin-left: 5px; padding: 3px 6px; border-radius: 4px; font-size: 10px; font-weight: 700; }
        .history-status.on { color: #15803d; background: #dcfce7; }
        .history-status.off { color: #b42318; background: #fee4e2; }
        .footer { margin-top: 24px; color: #a0a8b5; font-size: 11px; text-align: center; }
        body.dark { --ink: #e7eef9; --muted: #9eacc1; --line: #263750; --page: #111b2b; background: #111b2b; }
        body.dark .sidebar, body.dark .history { background: #172337; border-color: #263750; }
        body.dark .main { background: #111b2b; }
        body.dark .card, body.dark .panel { background: #1b2a40; box-shadow: 0 9px 26px rgba(0, 0, 0, .2); }
        body.dark .card:hover { box-shadow: 0 14px 30px rgba(0, 0, 0, .3); }
        body.dark .card-icon { color: #b8c8dd; background: #263750; }
        body.dark .player-avatar { background: linear-gradient(145deg, #3b82d6, #5e9be0); }
        body.dark .card-label, body.dark .player, body.dark .total { color: #e7eef9; }
        body.dark .card-value, body.dark .panel-head span, body.dark td, body.dark th { color: #b4c0d1; }
        body.dark .license { color: #9fb5d1; }
        body.dark .panel-head { background: linear-gradient(100deg, #203452, #1b2a40); }
        body.dark .history-list::before { border-color: #40526d; }
        body.dark .history-icon { border-color: #40526d; background: #1b2a40; }
        body.dark tbody tr:hover td { background: rgba(116, 174, 244, .08); }
        body.dark .ranking-item { border-color: #314765; }
        body.dark .ranking-item:hover { border-color: #4f7eaf; background: #203452; }
        body.dark .ranking-name { color: #e7eef9; }
        body.dark .ranking-time { color: #b4c0d1; }
        body.dark .about-panel { background: linear-gradient(145deg, #203452, #1b2a40); }
        body.dark .about-panel h3 { color: #a9cefa; }
        body.dark .about-panel p { color: #b4c0d1; }
        body.dark .theme-toggle { border-color: #405a7d; color: #d7e7fb; background: #203452; }
        body.dark .view-all { border-color: #405a7d; color: #a9cefa; background: #203452; }
        body.dark .view-all:hover { background: #29466d; }
        body.dark .nav a.active, body.dark .nav a:hover { background: #203b62; }
        @media (max-width: 1050px) { .app { grid-template-columns: 170px minmax(0, 1fr); } .history { display: none; } .below-panels { grid-template-columns: 1fr; } }
        @media (max-width: 700px) { .app { display: block; } .sidebar { padding: 16px; border-right: 0; border-bottom: 1px solid var(--line); } .brand { margin: 0 0 15px; } .nav { display: flex; overflow-x: auto; gap: 4px; } .nav a { white-space: nowrap; } .upgrade { display: none; } .main { padding: 24px 16px 36px; } .cards { grid-template-columns: 1fr; } .panel-head, .table-wrap { padding-left: 18px; padding-right: 18px; } .below-panels { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    @php
        $formatMinutes = function ($minutes) {
            $hours = intdiv((int) $minutes, 60);
            $remainingMinutes = (int) $minutes % 60;
            return $hours . ' jam ' . $remainingMinutes . ' menit';
        };
    @endphp
    <div class="app">
        <aside class="sidebar">
            <div class="brand"><img class="brand-logo" src="{{ asset('969restologo2.png') }}" alt="969 Resto"><span>969 RESTO</span></div>
            <nav class="nav">
                <a href="{{ url('/') }}"><span class="nav-icon">⌂</span>Home</a>
                <a class="active" href="{{ url('/') }}"><span class="nav-icon">ϟ</span>Duty Log</a>
                <a href="{{ route('players.index') }}"><span class="nav-icon">◉</span>Member</a>
                <a href="{{ route('players.index') }}"><span class="nav-icon">⚙</span>Settings</a>
            </nav>
        </aside>
        <main class="main">
            <div class="topline"><h1>969 RESTO</h1><div class="topline-actions"><span class="online"><span class="online-dot"></span>Realtime synced</span><button class="theme-toggle" type="button" data-theme-toggle>Mode Gelap</button><img class="top-logo" src="{{ asset('969restologo2.png') }}" alt="969 Resto"></div></div>
            <div class="cards">
                <div class="card"><div class="card-icon">⌂</div><div><div class="card-label">Welcome, Admin</div><div class="card-value">Dashboard 969 Resto</div></div></div>
                <div class="card"><div class="card-icon">▦</div><div><div class="card-label">TOTAL</div><div class="card-value">{{ $activePlayerCount }} People</div></div></div>
            </div>
            <section class="panel">
                <div class="panel-head"><div><div class="eyebrow">969R</div><h2>Tabel Duty 969 Resto</h2></div><div class="panel-head-actions"><span>Total Jam Duty</span><button class="view-all" type="button" data-table-toggle>Lihat semua</button></div></div>
                @if($weeklySummary->isEmpty())
                    <div class="empty">Belum ada member aktif. <a href="{{ route('players.index') }}">Kelola Member</a></div>
                @else
                    <div class="table-wrap duty-table-wrap" data-duty-table><table><thead><tr><th>Player</th><th>Steamhex</th><th>Total Jam Duty</th></tr></thead><tbody>
                        @foreach($weeklySummary as $player)
                            <tr><td><div class="player-cell"><span class="player-avatar">RR</span><span class="player">{{ $player->player_name }}</span></div></td><td class="license">{{ $player->license ?: '-' }}</td><td class="total">{{ $formatMinutes($player->total_mingguan) }}</td></tr>
                        @endforeach
                    </tbody></table></div>
                @endif
            </section>
            <div class="below-panels">
                <section class="panel ranking-panel">
                    <div class="panel-head"><div><div class="eyebrow">PERFORMA MINGGU INI</div><h2>Top 3 Duty</h2></div><span>Peringkat tertinggi</span></div>
                    @if($weeklySummary->isEmpty())
                        <div class="empty">Belum ada ranking duty.</div>
                    @else
                        <div class="ranking-list">
                            @foreach($weeklySummary->take(3) as $player)
                                <div class="ranking-item"><span class="ranking-number">{{ $loop->iteration }}</span><span class="ranking-name">{{ $player->player_name }}</span><span class="ranking-time">{{ $formatMinutes($player->total_mingguan) }}</span></div>
                            @endforeach
                        </div>
                    @endif
                </section>
                <section class="panel about-panel">
                    <h3>About 969 Resto</h3>
                    <p>Dashboard ini membantu memantau aktivitas duty crew 969 Resto secara realtime dari channel Discord.</p>
                    <p style="margin-top: 12px;">Total jam mengikuti nilai Total Mingguan yang dikirim oleh log duty.</p>
                </section>
            </div>
            <div class="footer">969 Duty Monitoring &copy; {{ date('Y') }}</div>
        </main>
        <aside class="history">
            <h2>History | Going On Duty</h2>
            <div class="history-list">
                @forelse($recentHistory as $log)
                    <div class="history-item"><span class="history-icon">✉</span><div><span class="history-name">{{ preg_replace('/\s*\([^)]*\)\s*$/', '', $log->player_name) }}</span><span class="history-time">{{ optional($log->end_date ?: $log->created_at)->format('M d, Y H:i') }} <span class="history-status {{ $log->status === 'on_duty' ? 'on' : 'off' }}">{{ $log->status === 'on_duty' ? 'On Duty' : 'Off Duty' }}</span></span></div></div>
                @empty
                    <div class="empty">Belum ada history duty.</div>
                @endforelse
            </div>
        </aside>
    </div>
    <script>
        const themeToggle = document.querySelector('[data-theme-toggle]');
        const tableToggle = document.querySelector('[data-table-toggle]');
        const dutyTable = document.querySelector('[data-duty-table]');
        const setTheme = (dark) => {
            document.body.classList.toggle('dark', dark);
            themeToggle.textContent = dark ? 'Mode Terang' : 'Mode Gelap';
            localStorage.setItem('duty-theme', dark ? 'dark' : 'light');
        };
        setTheme(localStorage.getItem('duty-theme') === 'dark');
        themeToggle.addEventListener('click', () => setTheme(!document.body.classList.contains('dark')));
        tableToggle?.addEventListener('click', () => {
            const expanded = dutyTable.classList.toggle('expanded');
            tableToggle.textContent = expanded ? 'Ringkas' : 'Lihat semua';
        });
        setTimeout(() => window.location.reload(), 15000);
    </script>
</body>
</html>
