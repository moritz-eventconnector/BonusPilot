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
            background: var(--brand-bg);
            color: #e5e7eb;
        }
        a { color: var(--brand-primary); text-decoration: none; }
        header {
            background: #0f172a;
            border-bottom: 1px solid #1f2937;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
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
            margin-left: 16px;
            color: #e2e8f0;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 24px;
        }
        .card {
            background: #0b1220;
            border-radius: 12px;
            border: 1px solid #1f2937;
            padding: 16px;
            margin-bottom: 16px;
            color: #e2e8f0;
        }
        .btn {
            display: inline-block;
            background: var(--brand-primary);
            color: #fff;
            padding: 10px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }
        .btn-secondary {
            background: #6b7280;
        }
        .btn-outline {
            background: transparent;
            border: 1px solid var(--brand-primary);
            color: var(--brand-primary);
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
            background: #0f172a;
            border-top: 1px solid #1f2937;
        }
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .filter-group {
            padding: 12px;
            background: #0b1220;
            border: 1px solid #1f2937;
            border-radius: 8px;
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
            background: linear-gradient(135deg, rgba(37,99,235,0.2), rgba(15,23,42,0.9));
            border: 1px solid #1f2937;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
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
            min-height: 280px;
            transform-style: preserve-3d;
            transition: transform 0.4s ease;
        }
        .flip-card.is-flipped .flip-card-inner {
            transform: rotateY(180deg);
        }
        .flip-card-face {
            position: absolute;
            inset: 0;
            background: #0b1220;
            border: 1px solid #1f2937;
            border-radius: 14px;
            padding: 18px;
            backface-visibility: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
        .info-btn {
            border: 1px solid #334155;
            background: transparent;
            color: #e2e8f0;
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
            background: #111827;
            border: 1px solid #1f2937;
            font-size: 12px;
        }
        @media (max-width: 768px) {
            nav a {
                margin-left: 8px;
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
    <nav>
        <a href="{{ route('home') }}">Home</a>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.bonuses.index') }}">Admin</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button class="btn btn-secondary" type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
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
