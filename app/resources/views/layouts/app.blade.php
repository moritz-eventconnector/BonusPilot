<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BonusPilot' }}</title>
    <style>
        :root {
            --brand-primary: {{ $settings->get('primary_color', '#2563eb') }};
            --brand-secondary: {{ $settings->get('secondary_color', '#1f2937') }};
            --brand-bg: {{ $settings->get('background_color', '#f9fafb') }};
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(180deg, #0a3d6f 0%, #0a6bb0 50%, #0a5e9b 100%);
            color: #e5e7eb;
            min-height: 100vh;
        }
        a { color: #e2e8f0; text-decoration: none; }
        header {
            background: linear-gradient(180deg, #0b345c 0%, #0a2a4a 100%);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: bold;
            color: #f8fafc;
        }
        .logo img {
            height: 40px;
        }
        nav a {
            margin-left: 20px;
            color: #f8fafc;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        .nav-socials {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .social-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.7);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #f8fafc;
            font-weight: 800;
            font-size: 14px;
        }
        .container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 24px;
        }
        .card {
            background: #0b2a46;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.15);
            padding: 16px;
            margin-bottom: 16px;
            color: #e2e8f0;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(180deg, #1d79c2, #155b92);
            color: #fff;
            padding: 10px 16px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .btn-secondary {
            background: #6b7280;
        }
        .btn-outline {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.5);
            color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            background: #1f2937;
            border-radius: 999px;
            font-size: 12px;
            color: #e2e8f0;
        }
        .grid {
            display: grid;
            gap: 16px;
        }
        .grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }
        .form-group {
            margin-bottom: 16px;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #374151;
            border-radius: 6px;
            background: #111827;
            color: #e5e7eb;
        }
        footer {
            margin-top: 40px;
            padding: 24px;
            background: linear-gradient(180deg, rgba(10,42,74,0.9), rgba(10,30,54,0.9));
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .filter-group {
            padding: 0;
            background: transparent;
            border: none;
            border-radius: 0;
        }
        .filter-label {
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #f8fafc;
            align-self: center;
        }
        .filter-pill {
            position: relative;
        }
        .filter-pill input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        .filter-pill span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 18px;
            border-radius: 12px;
            border: 2px solid rgba(255,255,255,0.7);
            color: #f8fafc;
            font-weight: 700;
            text-transform: uppercase;
            background: transparent;
            min-width: 120px;
        }
        .filter-pill input:checked + span {
            background: #f8fafc;
            color: #0a2a4a;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border-bottom: 1px solid #1f2937;
            padding: 10px;
            text-align: left;
        }
        .alert {
            padding: 12px;
            background: #0f766e;
            border: 1px solid #0f766e;
            border-radius: 6px;
            margin-bottom: 16px;
            color: #f0fdfa;
        }
        .hero {
            background: transparent;
            border: none;
            border-radius: 0;
            padding: 12px 0 24px;
            margin-bottom: 12px;
            text-align: center;
            color: #f8fafc;
        }
        .bonus-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 18px;
        }
        .flip-card {
            perspective: 1200px;
        }
        .flip-card-inner {
            position: relative;
            width: 100%;
            min-height: 200px;
            transform-style: preserve-3d;
            transition: transform 0.4s ease;
        }
        .flip-card.is-flipped .flip-card-inner {
            transform: rotateY(180deg);
        }
        .flip-card-face {
            position: absolute;
            inset: 0;
            background: #0b2a46;
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 18px;
            padding: 20px;
            backface-visibility: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.05);
            overflow: hidden;
        }
        .flip-card-back {
            transform: rotateY(180deg);
        }
        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }
        .bonus-row {
            display: grid;
            grid-template-columns: 1.2fr repeat(3, minmax(110px, 1fr)) auto;
            gap: 18px;
            align-items: center;
        }
        .bonus-brand {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .bonus-code {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.7);
        }
        .bonus-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .bonus-metric {
            text-align: center;
        }
        .bonus-metric strong {
            display: block;
            font-size: 18px;
        }
        .info-btn {
            border: 2px solid rgba(255,255,255,0.7);
            background: transparent;
            color: #f8fafc;
            border-radius: 999px;
            width: 32px;
            height: 32px;
            cursor: pointer;
        }
        .payment-methods {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }
        .payment-pill {
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(10,20,30,0.5);
            border: 1px solid rgba(255,255,255,0.15);
            font-size: 12px;
        }
        @media (max-width: 768px) {
            nav a {
                margin-left: 8px;
            }
            header {
                flex-direction: column;
                align-items: flex-start;
            }
            .nav-links {
                width: 100%;
                justify-content: space-between;
            }
            .bonus-row {
                grid-template-columns: 1fr;
                text-align: left;
            }
            .bonus-metric {
                text-align: left;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        @if($settings->get('logo_path'))
            <img src="{{ asset('storage/' . $settings->get('logo_path')) }}" alt="Logo">
        @endif
        <span>BonusPilot</span>
    </div>
    <nav class="nav-links">
        <div>
            <a href="{{ route('home') }}">Bonis</a>
            <a href="{{ route('page.show', 'gluecksrad') }}">Glücksrad</a>
        </div>
        <div class="nav-socials">
            @foreach(['instagram','telegram','discord','tiktok','youtube'] as $social)
                @if($settings->get($social))
                    <a class="social-icon" href="{{ $settings->get($social) }}" target="_blank" aria-label="{{ ucfirst($social) }}">
                        {{ strtoupper(substr($social, 0, 1)) }}
                    </a>
                @endif
            @endforeach
        </div>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.bonuses.index') }}">Admin</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button class="btn btn-secondary" type="submit">Logout</button>
            </form>
        @endauth
    </nav>
</header>

@auth
    @if(auth()->user()->is_admin)
        <div style="background:#111827;color:#fff;">
            <div class="container" style="display:flex;gap:16px;flex-wrap:wrap;">
                <a href="{{ route('admin.bonuses.index') }}" style="color:#fff;">Bonuses</a>
                <a href="{{ route('admin.filters.index') }}" style="color:#fff;">Filters</a>
                <a href="{{ route('admin.pages.index') }}" style="color:#fff;">Pages</a>
                <a href="{{ route('admin.settings.edit') }}" style="color:#fff;">Settings</a>
                <a href="{{ route('admin.backups.index') }}" style="color:#fff;">Backups</a>
            </div>
        </div>
    @endif
@endauth

<main class="container">
    @if(session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif
    @yield('content')
</main>

<footer>
    <div class="container">
        <strong>BonusPilot</strong>
        <div class="filters" style="margin-top:12px;">
            @foreach(['instagram','telegram','discord','tiktok','youtube'] as $social)
                @if($settings->get($social))
                    <a href="{{ $settings->get($social) }}" target="_blank">{{ ucfirst($social) }}</a>
                @endif
            @endforeach
        </div>
    </div>
</footer>
</body>
</html>
