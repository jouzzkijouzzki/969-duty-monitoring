<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>969 Resto | Member</title>
    <style>
        :root { --blue: #2878e5; --blue-soft: #e9f2ff; --ink: #303846; --muted: #8a94a6; --line: #edf0f4; --page: #f7f9fc; }
        * { box-sizing: border-box; }
        body { margin: 0; background: linear-gradient(135deg, #eef5ff 0%, #f7f9fc 48%, #e8f1ff 100%); color: var(--ink); font-family: "Segoe UI", Arial, sans-serif; }
        a { color: inherit; text-decoration: none; }
        button, input { font: inherit; }
        .app { display: grid; grid-template-columns: 190px minmax(0, 1fr); min-height: 100vh; }
        .sidebar { padding: 28px 22px; background: #fff; border-right: 1px solid var(--line); }
        .brand { display: flex; align-items: center; gap: 10px; margin: 0 10px 58px; font-size: 16px; font-weight: 700; }
        .brand-logo { width: 34px; height: 34px; object-fit: contain; }
        .nav { display: grid; gap: 10px; }
        .nav a { display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 7px; color: #98a2b3; font-size: 13px; transition: color .2s ease, background-color .2s ease, transform .2s ease; }
        .nav a.active, .nav a:hover { color: var(--blue); background: var(--blue-soft); }
        .nav a:hover { transform: translateX(3px); }
        .nav-icon { width: 17px; text-align: center; font-size: 16px; }
        .main { min-width: 0; padding: 36px 32px 45px; background: rgba(247, 249, 252, .72); }
        .topline { display: flex; justify-content: space-between; align-items: center; margin-bottom: 27px; }
        .topline-actions { display: flex; align-items: center; gap: 14px; }
        .topline h1 { margin: 0; font-size: 18px; font-weight: 700; }
        .online { color: #7f8a9c; font-size: 14px; }
        .online-dot { display: inline-block; width: 7px; height: 7px; margin-right: 6px; border-radius: 50%; background: #2fbd78; }
        .top-logo { width: 46px; height: 46px; object-fit: contain; }
        .theme-toggle { border: 1px solid #d5e3f7; border-radius: 6px; padding: 8px 11px; color: #315d93; background: #fff; font-size: 12px; cursor: pointer; transition: color .2s ease, background-color .2s ease, border-color .2s ease, transform .2s ease; }
        .theme-toggle:hover { border-color: var(--blue); color: var(--blue); transform: translateY(-2px); }
        .theme-toggle:focus-visible, .nav a:focus-visible, button:focus-visible { outline: 3px solid rgba(40, 120, 229, .28); outline-offset: 2px; }
        .intro { display: flex; justify-content: space-between; align-items: end; margin-bottom: 23px; }
        .intro h2 { margin: 0 0 6px; color: #244d86; font-size: 30px; font-weight: 500; }
        .intro p { margin: 0; color: var(--muted); font-size: 14px; }
        .back { color: var(--blue); font-size: 14px; font-weight: 700; }
        .grid { display: grid; grid-template-columns: minmax(0, 1fr) 285px; gap: 18px; align-items: start; }
        .tables-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 28px; align-items: start; margin-top: 28px; }
        .panel { background: rgba(255, 255, 255, .82); border: 1px solid #dce9fb; border-radius: 8px; box-shadow: 0 9px 26px rgba(39, 61, 92, .1); overflow: hidden; }
        .panel + .panel { margin-top: 18px; }
        .panel-head { padding: 22px 26px 17px; border-bottom: 1px solid #dce9fb; background: linear-gradient(100deg, #edf5ff, #f8fbff); }
        .panel-head h3 { margin: 0 0 6px; color: #244d86; font-size: 17px; }
        .panel-head p { margin: 0; color: var(--muted); font-size: 13px; line-height: 1.5; }
        .form-grid { display: grid; gap: 13px; padding: 22px 26px 26px; background: rgba(255, 255, 255, .68); }
        label { display: grid; gap: 7px; color: #566173; font-size: 11px; font-weight: 700; }
        input { width: 100%; padding: 10px 11px; border: 1px solid #dfe4eb; border-radius: 5px; color: var(--ink); background: #fbfcfe; font-size: 12px; }
        input:focus { outline: 2px solid #c8defd; border-color: var(--blue); }
        .primary-button, .candidate-button { border: 0; border-radius: 5px; padding: 10px 13px; color: #fff; background: var(--blue); font-size: 12px; font-weight: 700; cursor: pointer; transition: background-color .2s ease, transform .2s ease, box-shadow .2s ease; }
        .primary-button { justify-self: start; margin-top: 3px; }
        .primary-button:hover, .candidate-button:hover { background: #1d63c4; transform: translateY(-2px); box-shadow: 0 5px 12px rgba(40, 120, 229, .2); }
        .notice { margin: 0 0 18px; padding: 11px 14px; border-radius: 6px; color: #166534; background: #dcfce7; font-size: 12px; }
        .errors { color: #991b1b; background: #fee2e2; }
        .table-wrap { overflow-x: auto; padding: 0 26px 18px; }
        table { width: 100%; border-collapse: collapse; min-width: 560px; }
        th { padding: 13px 0 11px; color: #6e7888; font-size: 12px; font-weight: 400; text-align: left; text-transform: uppercase; }
        td { padding: 13px 0; border-top: 1px solid var(--line); color: #566173; font-size: 13px; vertical-align: middle; }
        .player { display: block; max-width: 170px; overflow: hidden; color: #3f4856; font-weight: 600; text-overflow: ellipsis; white-space: nowrap; }
        .license, .discord { color: #647084; font-family: monospace; font-size: 12px; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 5px; font-size: 10px; font-weight: 700; }
        .active { color: #15803d; background: #dcfce7; }
        .inactive { color: #6b7280; background: #f3f4f6; }
        .candidate-form, .deactivate-form { display: block; padding: 0; }
        .candidate-button { padding: 7px 10px; font-size: 10px; }
        .status-action { border: 0; border-radius: 5px; padding: 7px 10px; color: #fff; font-size: 10px; font-weight: 700; cursor: pointer; transition: background-color .2s ease, transform .2s ease, box-shadow .2s ease; }
        .status-action:hover { transform: translateY(-2px); box-shadow: 0 5px 12px rgba(39, 61, 92, .15); }
        .activate-button { background: #16a05d; }
        .activate-button:hover { background: #12804b; }
        .deactivate-button { background: #d64545; }
        .deactivate-button:hover { background: #b93434; }
        .empty { padding: 30px 20px; color: var(--muted); text-align: center; font-size: 12px; }
        .side-stat { display: grid; gap: 12px; padding: 14px; background: linear-gradient(155deg, #dbeaff, #f4f8ff); }
        .stat { padding: 15px; border: 1px solid #c9def9; border-radius: 7px; background: rgba(255, 255, 255, .64); }
        .stat:last-child { padding-bottom: 0; border-bottom: 0; }
        .stat-label { margin-bottom: 6px; color: var(--muted); font-size: 13px; }
        .stat-value { color: #2165b8; font-size: 25px; font-weight: 700; }
        .footer { margin-top: 24px; color: #a0a8b5; font-size: 11px; text-align: center; }
        body.dark { --ink: #e7eef9; --muted: #9eacc1; --line: #263750; --page: #111b2b; background: #111b2b; }
        body.dark .sidebar { background: #172337; border-color: #263750; }
        body.dark .main { background: #111b2b; }
        body.dark .panel { background: #1b2a40; border-color: #314765; box-shadow: 0 9px 26px rgba(0, 0, 0, .2); }
        body.dark .panel-head { border-color: #314765; background: linear-gradient(100deg, #203452, #1b2a40); }
        body.dark .form-grid { background: #1b2a40; }
        body.dark .panel-head h3, body.dark .player { color: #e7eef9; }
        body.dark .panel-head p, body.dark label, body.dark td, body.dark th, body.dark .stat-label { color: #b4c0d1; }
        body.dark input { border-color: #405a7d; color: #e7eef9; background: #152238; }
        body.dark .side-stat { background: linear-gradient(155deg, #1d3b63, #172a45); }
        body.dark .stat { border-color: #405a7d; background: rgba(27, 42, 64, .8); }
        body.dark .stat-value { color: #8fc0ff; }
        body.dark .license, body.dark .discord { color: #9fb5d1; }
        body.dark .theme-toggle { border-color: #405a7d; color: #d7e7fb; background: #203452; }
        body.dark .nav a.active, body.dark .nav a:hover { background: #203b62; }
        @media (max-width: 1050px) { .grid { grid-template-columns: 1fr; } .tables-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 700px) { .app { display: block; } .sidebar { padding: 16px; border-right: 0; border-bottom: 1px solid var(--line); } .brand { margin: 0 0 15px; } .nav { display: flex; overflow-x: auto; gap: 4px; } .nav a { white-space: nowrap; } .main { padding: 24px 16px 36px; } .intro { align-items: start; flex-direction: column; gap: 12px; } .tables-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="app">
        <aside class="sidebar">
            <div class="brand"><img class="brand-logo" src="{{ asset('969restologo2.png') }}" alt="969 Resto"><span>969 RESTO</span></div>
            <nav class="nav">
                <a href="{{ url('/') }}"><span class="nav-icon">⌂</span>Home</a>
                <a href="{{ url('/') }}"><span class="nav-icon">ϟ</span>Duty Log</a>
                <a class="active" href="{{ route('players.index') }}"><span class="nav-icon">◉</span>Member</a>
                <a href="{{ route('players.index') }}"><span class="nav-icon">⚙</span>Settings</a>
            </nav>
        </aside>

        <main class="main">
            <div class="topline"><h1>969 RESTO</h1><div class="topline-actions"><span class="online"><span class="online-dot"></span>Realtime synced</span><button class="theme-toggle" type="button" data-theme-toggle>Mode Gelap</button><img class="top-logo" src="{{ asset('969restologo2.png') }}" alt="969 Resto"></div></div>
            <div class="intro"><div><h2>Member</h2><p>Kelola player yang tampil pada dashboard duty.</p></div><a class="back" href="{{ url('/') }}">Kembali ke Duty Log</a></div>

            @if(session('success'))
                <div class="notice">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="notice errors">{{ $errors->first() }}</div>
            @endif

            <div class="grid">
                <div>
                    <section class="panel form-panel">
                        <div class="panel-head"><h3>Daftarkan player</h3><p>Player aktif akan muncul di dashboard dan memakai total duty dari log Discord.</p></div>
                        <form class="form-grid" method="POST" action="{{ route('players.store') }}">
                            @csrf
                            <label>Player Name<input name="player_name" value="{{ old('player_name') }}" placeholder="Contoh: Sultan N Ramaksa" required></label>
                            <label>Discord ID<input name="discord_id" value="{{ old('discord_id') }}" placeholder="Contoh: 325638371101638666" required></label>
                            <label>License Steam <span style="font-weight: 400; color: #9aa3b1;">(opsional)</span><input name="license" value="{{ old('license') }}" placeholder="Contoh: steam:11000013d5b1ea8"></label>
                            <button class="primary-button" type="submit">Simpan Player</button>
                        </form>
                    </section>

                    <div class="tables-grid">
                    <section class="panel">
                        <div class="panel-head"><h3>Kandidat dari log Discord</h3><p>Pilih player yang masih bekerja di 969 Resto.</p></div>
                        @if($candidates->isEmpty())
                            <div class="empty">Tidak ada kandidat baru dari log Discord.</div>
                        @else
                            <div class="table-wrap"><table><thead><tr><th>Player</th><th>Discord ID</th><th>License</th><th>Aksi</th></tr></thead><tbody>
                                @foreach($candidates as $candidate)
                                    <tr><td class="player">{{ $candidate->player_name }}</td><td class="discord">{{ $candidate->discord_id }}</td><td class="license">{{ $candidate->license ?: '-' }}</td><td><form class="candidate-form" method="POST" action="{{ route('players.store') }}">@csrf<input type="hidden" name="player_name" value="{{ $candidate->player_name }}"><input type="hidden" name="discord_id" value="{{ $candidate->discord_id }}"><input type="hidden" name="license" value="{{ $candidate->license }}"><button class="candidate-button" type="submit">Tambahkan</button></form></td></tr>
                                @endforeach
                            </tbody></table></div>
                        @endif
                    </section>

                    <section class="panel">
                        <div class="panel-head"><h3>Player terdaftar</h3><p>Nonaktifkan player tanpa menghapus histori duty.</p></div>
                        @if($players->isEmpty())
                            <div class="empty">Belum ada player yang didaftarkan.</div>
                        @else
                            <div class="table-wrap"><table><thead><tr><th>Player</th><th>Discord ID</th><th>License</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
                                @foreach($players as $player)
                                    <tr><td class="player">{{ $player->player_name }}</td><td class="discord">{{ $player->discord_id }}</td><td class="license">{{ $player->license ?: '-' }}</td><td><span class="badge {{ $player->is_active ? 'active' : 'inactive' }}">{{ $player->is_active ? 'Aktif' : 'Nonaktif' }}</span></td><td>@if($player->is_active)<form class="deactivate-form" method="POST" action="{{ route('players.deactivate', $player) }}">@csrf @method('PATCH')<button class="status-action deactivate-button" type="submit">Nonaktifkan</button></form>@else<form class="deactivate-form" method="POST" action="{{ route('players.activate', $player) }}">@csrf @method('PATCH')<button class="status-action activate-button" type="submit">Aktifkan</button></form>@endif</td></tr>
                                @endforeach
                            </tbody></table></div>
                        @endif
                    </section>
                    </div>
                </div>

                <aside class="panel side-stat">
                    <div class="stat"><div class="stat-label">Total terdaftar</div><div class="stat-value">{{ $players->count() }}</div></div>
                    <div class="stat"><div class="stat-label">Player aktif</div><div class="stat-value">{{ $players->where('is_active', true)->count() }}</div></div>
                    <div class="stat"><div class="stat-label">Kandidat baru</div><div class="stat-value">{{ $candidates->count() }}</div></div>
                </aside>
            </div>
            <div class="footer">969 Duty Monitoring &copy; {{ date('Y') }}</div>
        </main>
    </div>
</body>
<script>
    const themeToggle = document.querySelector('[data-theme-toggle]');
    const setTheme = (dark) => {
        document.body.classList.toggle('dark', dark);
        themeToggle.textContent = dark ? 'Mode Terang' : 'Mode Gelap';
        localStorage.setItem('duty-theme', dark ? 'dark' : 'light');
    };
    setTheme(localStorage.getItem('duty-theme') === 'dark');
    themeToggle.addEventListener('click', () => setTheme(!document.body.classList.contains('dark')));
</script>
</html>
