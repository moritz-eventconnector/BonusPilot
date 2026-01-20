<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? $settings->get('site_title', $settings->get('site_name', 'BonusPilot')) }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if($settings->get('favicon_path'))
        <link rel="icon" href="{{ asset('storage/' . $settings->get('favicon_path')) }}">
    @endif
    <style>
        :root {
            --brand-primary: {{ $settings->get('primary_color', '#2563eb') }};
            --brand-secondary: {{ $settings->get('secondary_color', '#1f2937') }};
            --brand-bg: {{ $settings->get('background_color', '#0b345c') }};
            --brand-bg-image: {{ $settings->get('background_image_path') ? "url('" . asset('storage/' . $settings->get('background_image_path')) . "')" : 'none' }};
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--brand-bg);
            background-image: var(--brand-bg-image);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #e5e7eb;
            min-height: 100vh;
        }
        a { color: #e2e8f0; text-decoration: none; }
        header {
            background: linear-gradient(180deg, #0b345c 0%, #0a2a4a 100%);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 18px 24px;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
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
            max-width: 160px;
        }
        nav a {
            margin-left: 20px;
            color: #f8fafc;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            transition: color 0.2s ease;
        }
        nav a:hover {
            color: #93c5fd;
        }
        .nav-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            text-align: center;
        }
        .nav-primary a {
            margin-left: 0;
        }
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            justify-content: flex-end;
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
            transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
        }
        .social-icon:hover {
            transform: translateY(-2px);
            background: rgba(255,255,255,0.16);
            box-shadow: 0 6px 14px rgba(2, 16, 32, 0.35);
        }
        .social-icon svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
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
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 18px rgba(0,0,0,0.2);
            filter: brightness(1.05);
        }
        .btn:active {
            transform: translateY(0);
        }
        .btn-secondary {
            background: #6b7280;
        }
        .btn-secondary:hover {
            filter: brightness(1.08);
        }
        .btn-outline {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.5);
            color: #f8fafc;
        }
        .btn-outline:hover {
            background: rgba(255,255,255,0.1);
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
        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
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
            transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        }
        .filter-pill:hover span {
            transform: translateY(-2px);
            background: rgba(248,250,252,0.1);
            box-shadow: 0 8px 16px rgba(2, 16, 32, 0.25);
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
        .table tr.dragging {
            opacity: 0.6;
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
            display: flex;
            flex-direction: column;
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
            background: radial-gradient(circle at top left, rgba(16,76,126,0.7), rgba(8,31,52,0.95) 55%) #0a2440;
            border: 1px solid rgba(255,255,255,0.45);
            border-radius: 20px;
            padding: 24px 30px;
            backface-visibility: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 10px 24px rgba(2,16,32,0.3);
            overflow: hidden;
        }
        .flip-card-front {
            justify-content: center;
            gap: 16px;
        }
        .bonus-flame {
            position: absolute;
            top: 16px;
            left: 16px;
            font-size: 22px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.35));
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
        .bonus-back-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(260px, 360px);
            gap: 26px;
            height: 100%;
        }
        .bonus-back-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
            text-align: left;
            word-break: break-word;
        }
        .bonus-back-details h3 {
            color: #4fb0ff;
            font-size: 20px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .bonus-back-details h3::before {
            content: "✔";
            font-size: 16px;
            color: #2f9bff;
            border: 2px solid #2f9bff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .bonus-back-details .bonus-list {
            margin: 0;
            padding: 0;
            list-style: none;
            display: grid;
            gap: 8px;
            color: #e2e8f0;
        }
        .bonus-back-details .bonus-list li {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .bonus-back-details .bonus-list li::before {
            content: "›";
            color: #f8fafc;
            font-size: 20px;
            line-height: 1;
        }
        .bonus-back-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 12px;
            padding-right: 16px;
            padding-left: 8px;
            padding-bottom: 12px;
        }
        .bonus-row {
            display: grid;
            grid-template-columns: minmax(240px, 1.2fr) repeat(4, minmax(110px, 1fr)) auto;
            gap: 22px;
            align-items: center;
        }
        .bonus-brand {
            display: flex;
            flex-direction: column;
            gap: 6px;
            align-items: center;
            text-align: center;
        }
        .bonus-logo {
            max-height: 56px;
            max-width: 180px;
            width: auto;
            height: auto;
            object-fit: contain;
        }
        .bonus-code {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #fde68a;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(250, 204, 21, 0.18);
            border: 1px solid rgba(250, 204, 21, 0.5);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.35);
        }
        .bonus-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            justify-content: flex-end;
            padding-right: 4px;
        }
        .bonus-actions-vertical {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }
        .bonus-actions-vertical .btn {
            width: 100%;
            justify-content: center;
        }
        .bonus-metric {
            text-align: center;
        }
        .bonus-metric strong {
            display: block;
            font-size: 20px;
            font-weight: 700;
        }
        .bonus-metric span {
            display: block;
            font-size: 14px;
            color: #dbeafe;
        }
        .bonus-info-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .info-btn {
            border: 2px solid rgba(79, 176, 255, 0.6);
            background: rgba(15, 38, 62, 0.95);
            color: #e2f2ff;
            border-radius: 999px;
            width: 34px;
            height: 34px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 16px rgba(3,21,38,0.35);
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        }
        .info-btn svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
            display: block;
            shape-rendering: geometricPrecision;
        }
        .info-btn:hover {
            transform: translateY(-2px);
            background: rgba(79, 176, 255, 0.15);
            border-color: rgba(79, 176, 255, 0.9);
            box-shadow: 0 10px 18px rgba(3,21,38,0.4);
        }
        .bonus-back-actions .info-btn {
            align-self: flex-end;
        }
        .payment-methods {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }
        .bonus-back-actions .payment-methods {
            justify-content: flex-end;
            margin-top: 0;
        }
        .payment-list {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .payment-chip {
            width: 52px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.12);
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }
        .payment-chip:hover {
            transform: translateY(-2px);
            background: rgba(255,255,255,0.16);
            box-shadow: 0 8px 14px rgba(2, 16, 32, 0.25);
        }
        .payment-chip svg {
            width: 28px;
            height: 28px;
        }
        .payment-heading {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #2f9bff;
            font-size: 18px;
            margin-bottom: 8px;
        }
        .payment-heading svg {
            width: 20px;
            height: 20px;
        }
        .editor-columns {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            align-items: start;
            margin: 12px 0;
        }
        .editor-column {
            min-height: 60px;
        }
        .editor-column img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        .form-section {
            padding: 18px;
            border-radius: 14px;
            border: 1px solid rgba(148,163,184,0.3);
            background: rgba(15, 23, 42, 0.6);
            margin-bottom: 20px;
        }
        .form-section h3 {
            margin-top: 0;
            margin-bottom: 14px;
            font-size: 18px;
            color: #93c5fd;
        }
        .admin-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            justify-content: space-between;
        }
        .admin-inline {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }
        .admin-card {
            background: rgba(15, 23, 42, 0.75);
            border-radius: 16px;
            border: 1px solid rgba(148,163,184,0.3);
            padding: 18px;
        }
        .admin-muted {
            color: #94a3b8;
        }
        .form-help {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: #94a3b8;
        }
        .form-note {
            padding: 10px 12px;
            border-radius: 12px;
            background: rgba(15, 23, 42, 0.8);
            border: 1px dashed rgba(148,163,184,0.4);
            color: #cbd5f5;
        }
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
            margin-top: 8px;
        }
        .checkbox-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 12px;
            border: 1px solid rgba(148,163,184,0.3);
            background: rgba(15, 23, 42, 0.55);
        }
        .checkbox-pill input {
            margin: 0;
        }
        @media (max-width: 768px) {
            .container {
                padding: 18px;
            }
            nav a {
                margin-left: 0;
            }
            header {
                grid-template-columns: 1fr;
                align-items: stretch;
                padding: 16px;
            }
            .nav-primary {
                justify-content: flex-start;
                flex-wrap: wrap;
            }
            .nav-actions {
                width: 100%;
                justify-content: flex-start;
                gap: 12px;
            }
            .nav-socials {
                justify-content: flex-start;
                flex-wrap: wrap;
            }
            .filters {
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: 6px;
                gap: 8px;
            }
            .filter-pill span {
                min-width: 96px;
                padding: 8px 12px;
                font-size: 12px;
            }
            .hero {
                text-align: left;
            }
            .bonus-row {
                grid-template-columns: 1fr;
                text-align: left;
                gap: 16px;
            }
            .bonus-metric {
                text-align: left;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 10px 12px;
                background: rgba(15, 23, 42, 0.55);
                border-radius: 12px;
            }
            .bonus-metric strong {
                font-size: 18px;
            }
            .bonus-brand {
                padding-left: 0;
                align-items: flex-start;
                text-align: left;
            }
            .bonus-logo {
                max-width: 140px;
            }
            .bonus-actions {
                width: 100%;
                justify-content: flex-start;
            }
            .bonus-actions .btn {
                flex: 1 1 auto;
            }
            .bonus-back-layout {
                grid-template-columns: 1fr;
            }
            .bonus-back-actions {
                align-items: stretch;
            }
            .bonus-back-actions .payment-methods {
                justify-content: flex-start;
            }
            .bonus-actions-vertical .btn {
                width: 100%;
            }
            .flip-card-face {
                padding: 18px;
            }
            .editor-columns {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
@php
    $socialIcons = [
        'instagram' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4zm0 2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H7zm11 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm-6 2.5a4.5 4.5 0 1 1 0 9a4.5 4.5 0 0 1 0-9zm0 2a2.5 2.5 0 1 0 0 5a2.5 2.5 0 0 0 0-5z"/></svg>',
        'telegram' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.5 4.6 2.8 11.7c-1 .4-1 1.2-.2 1.5l4.8 1.5 1.8 5.6c.2.6.3.8.8.8.5 0 .7-.2 1-.5l2.3-2.2 4.8 3.5c.9.5 1.5.2 1.7-.8L23 6.1c.3-1.2-.5-1.8-1.5-1.4zM9.1 14.3l9.2-5.6c.5-.3 1-.1.6.2l-7.6 6.8-.3 3.4-1.5-4.8z"/></svg>',
        'discord' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.3 5.4a18 18 0 0 0-4.4-1.4l-.2.4a13 13 0 0 1 3.8 1.7c-3.4-1.8-7.6-1.8-11 0a13 13 0 0 1 3.8-1.7l-.2-.4a18 18 0 0 0-4.4 1.4C4.8 8.7 3.6 11.8 4 15c2 1.5 4 2.4 6.1 2.9l.7-1.1a7.8 7.8 0 0 1-2.2-1.1l.5-.4a10 10 0 0 0 7.8 0l.5.4c-.7.5-1.4.9-2.2 1.1l.7 1.1c2.1-.5 4.1-1.4 6.1-2.9.5-3.2-.8-6.3-2.7-9.6zM9.6 13.4a1.5 1.5 0 1 1 0-3a1.5 1.5 0 0 1 0 3zm4.8 0a1.5 1.5 0 1 1 0-3a1.5 1.5 0 0 1 0 3z"/></svg>',
        'tiktok' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16.7 3c.5 1.7 1.9 3.1 3.6 3.6v3a7 7 0 0 1-3.6-1.2v5.7a5.4 5.4 0 1 1-5.4-5.4c.4 0 .8 0 1.2.1v3.1a2.4 2.4 0 1 0 1.8 2.3V3z"/></svg>',
        'youtube' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22.5 7.2a3 3 0 0 0-2.1-2.1C18.5 4.5 12 4.5 12 4.5s-6.5 0-8.4.6A3 3 0 0 0 1.5 7.2 31 31 0 0 0 1 12a31 31 0 0 0 .5 4.8 3 3 0 0 0 2.1 2.1c1.9.6 8.4.6 8.4.6s6.5 0 8.4-.6a3 3 0 0 0 2.1-2.1A31 31 0 0 0 23 12a31 31 0 0 0-.5-4.8zM10 15.5V8.5l6 3.5-6 3.5z"/></svg>',
    ];
@endphp
<header>
    <div class="logo">
        @if($settings->get('logo_path'))
            <img src="{{ asset('storage/' . $settings->get('logo_path')) }}" alt="Logo">
        @endif
        <span>{{ $settings->get('site_name', 'BonusPilot') }}</span>
    </div>
    <div class="nav-primary">
        <a href="{{ route('home') }}">{{ __('ui.nav.bonuses') }}</a>
        <a href="{{ route('page.show', 'gluecksrad') }}">{{ __('ui.nav.wheel') }}</a>
    </div>
    <nav class="nav-actions">
        @php
            $currentLocale = app()->getLocale();
            $toggleLocale = $currentLocale === 'de' ? 'en' : 'de';
        @endphp
        <div class="nav-socials">
            @foreach(['instagram','telegram','discord','tiktok','youtube'] as $social)
                @if($settings->get($social))
                    <a class="social-icon" href="{{ $settings->get($social) }}" target="_blank" aria-label="{{ ucfirst($social) }}">
                        {!! $socialIcons[$social] !!}
                    </a>
                @endif
            @endforeach
        </div>
        <form method="POST" action="{{ route('language.switch', $toggleLocale) }}" style="display:inline">
            @csrf
            <button class="btn btn-outline" type="submit" aria-label="{{ __('ui.language.switch') }}">
                {{ strtoupper($toggleLocale) }}
            </button>
        </form>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.bonuses.index') }}">{{ __('ui.nav.admin') }}</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button class="btn btn-secondary" type="submit">{{ __('ui.nav.logout') }}</button>
            </form>
        @endauth
    </nav>
</header>

@auth
    @if(auth()->user()->is_admin)
        <div style="background:#111827;color:#fff;">
            <div class="container" style="display:flex;gap:16px;flex-wrap:wrap;">
                <a href="{{ route('admin.bonuses.index') }}" style="color:#fff;">{{ __('ui.nav.bonuses_admin') }}</a>
                <a href="{{ route('admin.filters.index') }}" style="color:#fff;">{{ __('ui.nav.filters') }}</a>
                <a href="{{ route('admin.pages.index') }}" style="color:#fff;">{{ __('ui.nav.pages') }}</a>
                <a href="{{ route('admin.analytics.index') }}" style="color:#fff;">{{ __('ui.nav.analytics') }}</a>
                <a href="{{ route('admin.settings.edit') }}" style="color:#fff;">{{ __('ui.nav.settings') }}</a>
                <a href="{{ route('admin.backups.index') }}" style="color:#fff;">{{ __('ui.nav.backups') }}</a>
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
        <strong>{{ $settings->get('site_name', 'BonusPilot') }}</strong>
        <div class="filters" style="margin-top:12px;">
            @foreach(['instagram','telegram','discord','tiktok','youtube'] as $social)
                @if($settings->get($social))
                    <a class="social-icon" href="{{ $settings->get($social) }}" target="_blank" aria-label="{{ ucfirst($social) }}">
                        {!! $socialIcons[$social] !!}
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</footer>
</body>
</html>
