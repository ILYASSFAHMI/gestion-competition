<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CompétitionEcoles') }} — @yield('title', 'Accueil')</title>
    <meta name="description" content="Plateforme de compétition inter-écoles">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary:   #6366f1;
            --primary-d: #4f46e5;
            --accent:    #f59e0b;
            --bg:        #0a0b14;
            --bg-card:   #111827;
            --border:    #1f2937;
            --text:      #e2e8f0;
            --muted:     #64748b;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; margin: 0; }
        a { color: inherit; text-decoration: none; }

        /* ── Navbar ── */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            background: rgba(10,11,20,0.92); backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            padding: 0 1.5rem; height: 64px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .navbar-brand {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.3rem; font-weight: 800; letter-spacing: -0.5px;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .navbar-brand .trophy { font-size: 1.4rem; }
        .nav-links { display: flex; align-items: center; gap: 0.5rem; list-style: none; margin: 0; padding: 0; }
        .nav-links a {
            padding: 0.4rem 0.9rem; border-radius: 8px;
            font-size: 0.875rem; font-weight: 500; color: var(--muted);
            transition: all 0.2s;
        }
        .nav-links a:hover, .nav-links a.active { color: var(--primary); background: rgba(99,102,241,0.1); }
        .nav-right { display: flex; align-items: center; gap: 0.75rem; }
        .avatar {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.85rem; color: white;
            cursor: pointer;
        }
        .badge-admin {
            font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
            background: rgba(245,158,11,0.15); color: var(--accent);
            border: 1px solid rgba(245,158,11,0.3); padding: 0.15rem 0.5rem; border-radius: 4px;
        }
        .badge-team {
            font-size: 0.7rem; font-weight: 600;
            background: rgba(99,102,241,0.15); color: var(--primary);
            border: 1px solid rgba(99,102,241,0.3); padding: 0.15rem 0.6rem; border-radius: 4px;
        }

        /* ── Dropdown ── */
        .dropdown { position: relative; }
        .dropdown-menu {
            position: absolute; right: 0; top: calc(100% + 8px);
            background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px;
            min-width: 200px; padding: 0.5rem; display: none; z-index: 200;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .dropdown:hover .dropdown-menu { display: block; }
        .dropdown-menu a, .dropdown-menu button {
            display: flex; align-items: center; gap: 0.6rem;
            width: 100%; padding: 0.55rem 0.75rem;
            background: none; border: none; color: var(--muted);
            font-size: 0.875rem; border-radius: 8px; cursor: pointer; font-family: inherit;
            transition: all 0.15s; text-align: left;
        }
        .dropdown-menu a:hover, .dropdown-menu button:hover { background: rgba(99,102,241,0.1); color: var(--text); }
        .dropdown-sep { height: 1px; background: var(--border); margin: 0.4rem 0; }

        /* ── Cards ── */
        .card {
            background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px;
            padding: 1.5rem; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .card:hover { border-color: rgba(99,102,241,0.3); }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.55rem 1.2rem; border-radius: 10px;
            font-size: 0.875rem; font-weight: 600; border: none; cursor: pointer;
            font-family: 'Inter', sans-serif; transition: all 0.2s; text-decoration: none;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-d); transform: translateY(-1px); box-shadow: 0 4px 20px rgba(99,102,241,0.35); }
        .btn-secondary { background: transparent; border: 1px solid var(--border); color: var(--muted); }
        .btn-secondary:hover { border-color: var(--primary); color: var(--primary); }
        .btn-danger { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #f87171; }
        .btn-danger:hover { background: rgba(239,68,68,0.2); }
        .btn-warning { background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); color: var(--accent); }
        .btn-warning:hover { background: rgba(245,158,11,0.2); }
        .btn-sm { padding: 0.35rem 0.8rem; font-size: 0.8rem; }

        /* ── Forms ── */
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--muted); margin-bottom: 0.4rem; letter-spacing: 0.5px; }
        input, select, textarea {
            width: 100%; background: rgba(0,0,0,0.3); border: 1px solid var(--border);
            border-radius: 10px; padding: 0.65rem 1rem; color: var(--text);
            font-size: 0.9rem; font-family: 'Inter', sans-serif; outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }
        textarea { resize: vertical; min-height: 90px; }
        .form-error { color: #f87171; font-size: 0.8rem; margin-top: 0.35rem; }

        /* ── Alerts ── */
        .alert { padding: 0.9rem 1.25rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.875rem; font-weight: 500; display: flex; align-items: center; gap: 0.6rem; }
        .alert-success { background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.3); color: #34d399; }
        .alert-error   { background: rgba(239,68,68,0.08);  border: 1px solid rgba(239,68,68,0.3);  color: #f87171; }
        .alert-info    { background: rgba(99,102,241,0.08); border: 1px solid rgba(99,102,241,0.3); color: var(--primary); }

        /* ── Tables ── */
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        th { text-align: left; padding: 0.75rem 1rem; font-size: 0.72rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--muted); border-bottom: 1px solid var(--border); }
        td { padding: 0.9rem 1rem; border-bottom: 1px solid rgba(31,41,55,0.5); color: var(--text); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(99,102,241,0.03); }

        /* ── Page structure ── */
        .page-container { max-width: 1200px; margin: 0 auto; padding: 2rem 1.5rem; }
        .page-header { margin-bottom: 2rem; }
        .page-title { font-family: 'Space Grotesk', sans-serif; font-size: 1.75rem; font-weight: 800; letter-spacing: -0.5px; margin: 0 0 0.3rem; }
        .page-subtitle { color: var(--muted); font-size: 0.9rem; margin: 0; }

        /* ── Stat boxes ── */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-box { background: var(--bg-card); border: 1px solid var(--border); border-radius: 14px; padding: 1.25rem 1.5rem; }
        .stat-value { font-family: 'Space Grotesk', sans-serif; font-size: 2rem; font-weight: 700; line-height: 1; }
        .stat-label { font-size: 0.75rem; color: var(--muted); margin-top: 0.35rem; text-transform: uppercase; letter-spacing: 0.5px; }

        /* ── Progress ── */
        .progress { background: rgba(255,255,255,0.05); border-radius: 99px; height: 6px; overflow: hidden; }
        .progress-bar { height: 100%; border-radius: 99px; background: linear-gradient(90deg, var(--primary), #8b5cf6); transition: width 0.5s; }

        /* ── Rank badge ── */
        .rank-1 { color: #fbbf24; font-weight: 800; }
        .rank-2 { color: #94a3b8; font-weight: 700; }
        .rank-3 { color: #b45309; font-weight: 700; }

        @media (max-width: 768px) {
            .nav-links { display: none; }
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar">
    <a href="{{ route('home') }}" class="navbar-brand">
        <span class="trophy">🏆</span>
        <span>Compétition<span style="color:var(--primary)">Écoles</span></span>
    </a>

    @auth
    <ul class="nav-links">
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">🏠 Accueil</a></li>
        <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">📊 Mon espace</a></li>
        @if(auth()->user()->isAdmin())
        <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">⚙️ Admin</a></li>
        @endif
    </ul>

    <div class="nav-right">
        @if(auth()->user()->isAdmin())
            <span class="badge-admin">Admin</span>
        @elseif(auth()->user()->hasTeam())
            <span class="badge-team">{{ auth()->user()->team->name }}</span>
        @endif

        <div class="dropdown">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div class="dropdown-menu">
                <div style="padding:0.5rem 0.75rem 0.75rem; border-bottom:1px solid var(--border); margin-bottom:0.4rem;">
                    <div style="font-weight:600;font-size:0.875rem;">{{ auth()->user()->name }}</div>
                    <div style="color:var(--muted);font-size:0.75rem;">{{ auth()->user()->email }}</div>
                </div>
                @if(!auth()->user()->isAdmin() && !auth()->user()->hasTeam())
                <a href="{{ route('teams.join') }}">🔑 Rejoindre une équipe</a>
                @endif
                @if(!auth()->user()->isAdmin() && auth()->user()->hasTeam())
                <a href="{{ route('dashboard') }}">🛡️ Mon équipe</a>
                @endif
                <div class="dropdown-sep"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">🚪 Déconnexion</button>
                </form>
            </div>
        </div>
    </div>
    @endauth

    @guest
    <div style="display:flex;gap:0.75rem;">
        <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Connexion</a>
        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">S'inscrire</a>
    </div>
    @endguest
</nav>

{{-- Flash Messages --}}
@if(session('success'))
<div class="page-container" style="padding-bottom:0;">
    <div class="alert alert-success">✅ {{ session('success') }}</div>
</div>
@endif
@if(session('error'))
<div class="page-container" style="padding-bottom:0;">
    <div class="alert alert-error">⚠️ {{ session('error') }}</div>
</div>
@endif
@if(session('info'))
<div class="page-container" style="padding-bottom:0;">
    <div class="alert alert-info">ℹ️ {{ session('info') }}</div>
</div>
@endif

{{ $slot }}

<footer style="text-align:center;padding:2rem;color:var(--muted);font-size:0.8rem;border-top:1px solid var(--border);margin-top:4rem;">
    🏆 Compétition Inter-Écoles &mdash; {{ date('Y') }}
</footer>

@stack('scripts')
</body>
</html>