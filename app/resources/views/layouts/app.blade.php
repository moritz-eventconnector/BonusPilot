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
            font-family: Arial, sans-serif;
            background: var(--brand-bg);
            color: #111827;
        }
        a { color: var(--brand-primary); text-decoration: none; }
        header {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
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
            color: var(--brand-secondary);
        }
        .logo img {
            height: 40px;
        }
        nav a {
            margin-left: 16px;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 24px;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            padding: 16px;
            margin-bottom: 16px;
        }
        .btn {
            display: inline-block;
            background: var(--brand-primary);
            color: #fff;
            padding: 10px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }
        .btn-secondary {
            background: #6b7280;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            background: #e5e7eb;
            border-radius: 999px;
            font-size: 12px;
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
            border: 1px solid #d1d5db;
            border-radius: 6px;
        }
        footer {
            margin-top: 40px;
            padding: 24px;
            background: #fff;
            border-top: 1px solid #e5e7eb;
        }
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .filter-group {
            padding: 12px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border-bottom: 1px solid #e5e7eb;
            padding: 10px;
            text-align: left;
        }
        .alert {
            padding: 12px;
            background: #ecfeff;
            border: 1px solid #cffafe;
            border-radius: 6px;
            margin-bottom: 16px;
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
