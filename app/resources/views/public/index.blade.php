@extends('layouts.app')

@section('content')
@php
    $heroEnabled = $settings->get('home_hero_enabled', '1') !== '0';
    $heroTitle = $settings->get('home_hero_title');
    $heroSubtitle = $settings->get('home_hero_subtitle');
    $defaultHeroTitle = 'Bonus Highlights';
    $defaultHeroSubtitle = 'Filtere deine Boni und klicke auf ⓘ für mehr Details.';
    $filterSlug = $filterSlug ?? null;
    $paymentIcons = [
        'visa' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M2 7h20v10H2z"/><path fill="#1a1f71" d="M2 7h20v10H2z"/><path fill="#fff" d="M7.2 15.6h-1.4l.9-5.1h1.4zm5.6-3.5c-.2-.7-.8-.9-1.4-.9-1 0-1.6.5-1.6 1.2 0 .9 1.3 1.1 1.3 1.6 0 .2-.2.4-.7.4-.4 0-.9-.1-1.2-.3l-.2.9c.4.2.9.3 1.5.3 1.1 0 1.8-.5 1.8-1.3 0-1-1.3-1.1-1.3-1.6 0-.2.2-.4.7-.4.3 0 .6.1.9.2l.2-.8zm6 3.5h-1.3c-.1 0-.2-.1-.2-.2l-1-4.9H17l-1.1 5.1h-1.4l1.9-5.1h1.2c.2 0 .4.1.4.3zm-5.1-5.1h-1.3l-1.8 5.1H12l.3-.9h1.9l.2.9h1.3zm-1 3.2.5-1.4.3 1.4z"/></svg>',
        'mastercard' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="12" r="6" fill="#eb001b"/><circle cx="15" cy="12" r="6" fill="#f79e1b"/><path fill="#ff5f00" d="M12 6a6 6 0 0 0 0 12a6 6 0 0 0 0-12z"/></svg>',
        'paypal' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#003087" d="M7.1 19H4.7L6.4 6h3.5c3.1 0 4.8 1.4 4.2 4.4-.5 2.6-2.4 3.9-5.2 3.9H7.3z"/><path fill="#009cde" d="M18.8 10.1c-.2 1.6-1.2 5.9-6.8 5.9H10l-.5 3H7.1l.2-1.2 1-6.6h2.3c3.4 0 5.4-1.4 6-4.1.2-.8.2-1.5.2-2.1 1 .6 1.4 1.7 1 3.1z"/></svg>',
        'skrill' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#7a1e7a" d="M3 7h12.2c2.2 0 3.8 1.4 3.8 3.4 0 2-1.6 3.4-3.8 3.4H10L9.6 17H6.8l1.1-7.2H3z"/><path fill="#7a1e7a" d="M20.5 17h-2.6l-.8-3.2h2.5z"/></svg>',
        'bitcoin' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10" fill="#f7931a"/><path fill="#fff" d="M13.5 6.5c1.6.3 2.6 1.3 2.5 2.7 0 1.1-.6 1.8-1.6 2.1 1.2.4 1.9 1.2 1.9 2.5 0 1.8-1.2 2.9-3.2 3.1V19h-1.3v-1.1h-1.1V19H9.4v-1.2H8v-1h1.4V7.2H8v-1h1.4V5h1.3v1.1h1.1V5h1.3v1.3zm-2.8 1.4v2.6h1.3c1 0 1.6-.4 1.6-1.3 0-.9-.6-1.3-1.6-1.3zm0 3.9v3h1.6c1.1 0 1.7-.5 1.7-1.5s-.6-1.5-1.7-1.5z"/></svg>',
        'litecoin' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10" fill="#b5b5b5"/><path fill="#fff" d="M9.6 16.5h5.2l.5-2H12l.4-1.6h2.8l.4-1.6h-2.8l1-4H11l-1.1 4.3-1.2.5-.4 1.6 1.2-.5-.4 1.6-1.2.5-.4 1.6 1.1-.5z"/></svg>',
        'ethereum' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10" fill="#3c3c3d"/><path fill="#fff" d="M12 4l4 6.6-4 2.4-4-2.4L12 4zm0 15.5-4-5.6 4 2.3 4-2.3-4 5.6z"/></svg>',
        'paysafecard' => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="6" width="18" height="12" rx="2" fill="#fff"/><path fill="#2b6cb0" d="M5 9h8v2H5zm0 4h6v2H5z"/><path fill="#ef4444" d="M15 8h4v8h-4z"/></svg>',
        'sofort' => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="6" width="18" height="12" rx="2" fill="#ff9acb"/><path fill="#fff" d="M7 12h4l-1.5 2H5.5z"/><path fill="#fff" d="M14 10h4v4h-4z"/></svg>',
    ];
    $normalizeMethod = fn ($method) => strtolower(preg_replace('/\s+/', '', $method));
@endphp
@if($heroEnabled)
    <div class="hero">
        @if($heroTitle || $heroSubtitle)
            @if($heroTitle)
                <h1>{{ $heroTitle }}</h1>
            @endif
            @if($heroSubtitle)
                <p>{{ $heroSubtitle }}</p>
            @endif
        @else
            <h1>{{ $defaultHeroTitle }}</h1>
            <p>{{ $defaultHeroSubtitle }}</p>
        @endif
    </div>
@endif

<div class="filters" style="margin-bottom:28px;justify-content:center;">
    <span class="filter-label">Filter:</span>
    <a class="filter-pill" href="{{ route('home') }}">
        <span {{ $filterSlug ? '' : 'style=background:#f8fafc;color:#0a2a4a;' }}>Alle Boni</span>
    </a>
    @foreach($groups as $group)
        @foreach($group->options as $option)
            @php
                $isActive = $filterSlug === $option->slug;
                $query = $isActive ? '' : '?' . http_build_query(['filter' => $option->slug]);
            @endphp
            <a class="filter-pill" href="{{ route('home') . $query }}">
                <span {{ $isActive ? 'style=background:#f8fafc;color:#0a2a4a;' : '' }}>{{ $option->name }}</span>
            </a>
        @endforeach
    @endforeach
</div>

<div class="bonus-grid">
    @forelse($bonuses as $bonus)
        @php
            $methods = array_filter(array_map('trim', explode(',', $bonus->payment_methods ?? '')));
            $metricLabels = [
                'bonus_percent' => $bonus->bonus_percent_label ?: 'Bonus',
                'max_bonus' => $bonus->max_bonus_label ?: 'Maxbonus',
                'max_bet' => $bonus->max_bet_label ?: 'Maxbet',
                'wager' => $bonus->wager_label ?: 'Wager',
            ];
            $backLines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $bonus->back_text ?? ''))));
        @endphp
        <div class="flip-card" data-card>
            <div class="flip-card-inner">
                <div class="flip-card-face">
                    @if($bonus->is_featured)
                        <span class="bonus-flame" aria-hidden="true">🔥</span>
                    @endif
                    <div class="bonus-row">
                        <div class="bonus-brand">
                            @if($bonus->bonus_icon_path)
                                <img class="bonus-logo" src="{{ route('bonus.icon', $bonus) }}" alt="{{ $bonus->title }}">
                            @else
                                <h3>{{ $bonus->title }}</h3>
                            @endif
                            @if($bonus->bonus_code)
                                <span class="bonus-code">
                                    {{ $bonus->bonus_code_label ?: 'Code' }} ➜ {{ $bonus->bonus_code }}
                                </span>
                            @endif
                            @if($bonus->short_text)
                                <span>{{ $bonus->short_text }}</span>
                            @endif
                        </div>
                        <div class="bonus-metric">
                            <strong>{{ $bonus->bonus_percent ? $bonus->bonus_percent . '%' : '—' }}</strong>
                            <span>{{ $metricLabels['bonus_percent'] }}</span>
                        </div>
                        <div class="bonus-metric">
                            <strong>{{ $bonus->max_bonus ?: '—' }}</strong>
                            <span>{{ $metricLabels['max_bonus'] }}</span>
                        </div>
                        <div class="bonus-metric">
                            <strong>{{ $bonus->max_bet ?: '—' }}</strong>
                            <span>{{ $metricLabels['max_bet'] }}</span>
                        </div>
                        <div class="bonus-metric">
                            <strong>{{ $bonus->wager ?: '—' }}</strong>
                            <span>{{ $metricLabels['wager'] }}</span>
                        </div>
                        <div class="bonus-actions">
                            @if($bonus->play_url)
                                <a class="btn" href="{{ $bonus->play_url }}" target="_blank">
                                    {{ $bonus->cta_label ?: 'Play now' }}
                                </a>
                            @else
                                <span class="badge">No link yet</span>
                            @endif
                            <button class="info-btn" type="button" data-flip aria-label="More info">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill="currentColor" d="M12 2a10 10 0 1 0 0 20a10 10 0 0 0 0-20zm0 4.75a1.25 1.25 0 1 1 0 2.5a1.25 1.25 0 0 1 0-2.5zm2 12.5h-4v-1.8h1.2V11.2H10V9.5h2.4c.6 0 1 .4 1 1v6h1.6v1.8z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flip-card-face flip-card-back">
                    @if($bonus->is_featured)
                        <span class="bonus-flame" aria-hidden="true">🔥</span>
                    @endif
                    <div class="bonus-back-layout">
                        <div class="bonus-back-details">
                            <div class="card-top">
                                <h3>Information</h3>
                            </div>
                            @if(count($backLines))
                                <ul class="bonus-list">
                                    @foreach($backLines as $line)
                                        <li>{{ $line }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Keine weiteren Details vorhanden.</p>
                            @endif
                        </div>
                        <div class="bonus-back-actions">
                            <button class="info-btn" type="button" data-flip aria-label="Back">⟲</button>
                            @if(count($methods))
                                <div class="payment-methods">
                                    <div class="payment-heading">
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2 0v10h12V7z"/><path fill="currentColor" d="M6 10h6v2H6z"/></svg>
                                        <span>Payments</span>
                                    </div>
                                    <div class="payment-list">
                                        @foreach($methods as $method)
                                            @php
                                                $icon = $paymentIcons[$normalizeMethod($method)] ?? null;
                                            @endphp
                                            <span class="payment-chip" aria-label="{{ $method }}">
                                                @if($icon)
                                                    {!! $icon !!}
                                                @else
                                                    <span class="bonus-info-pill">{{ $method }}</span>
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="bonus-actions bonus-actions-vertical">
                                @if($bonus->play_url)
                                    <a class="btn" href="{{ $bonus->play_url }}" target="_blank">
                                        {{ $bonus->cta_label ?: 'Play now' }}
                                    </a>
                                @endif
                                <button class="btn btn-secondary" type="button" data-flip>Go Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p>No bonuses found.</p>
    @endforelse
</div>

<script>
    const cards = document.querySelectorAll('[data-card]');

    const updateCardHeights = () => {
        cards.forEach((card) => {
            const inner = card.querySelector('.flip-card-inner');
            const faces = card.querySelectorAll('.flip-card-face');
            const heights = Array.from(faces).map((face) => face.scrollHeight);
            const maxHeight = Math.max(220, ...heights);
            inner.style.minHeight = `${maxHeight}px`;
        });
    };

    const closeAll = () => {
        cards.forEach((card) => card.classList.remove('is-flipped'));
    };

    cards.forEach((card) => {
        card.addEventListener('click', (event) => {
            const flipButton = event.target.closest('[data-flip]');
            if (!flipButton) return;
            const isFlipped = card.classList.contains('is-flipped');
            closeAll();
            if (!isFlipped) {
                card.classList.add('is-flipped');
                flipButton.focus();
            }
            updateCardHeights();
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeAll();
        }
        if (event.key === 'Enter') {
            const focused = document.activeElement;
            if (focused && focused.matches('[data-flip]')) {
                focused.click();
            }
        }
    });

    window.addEventListener('load', updateCardHeights);
    window.addEventListener('resize', updateCardHeights);
</script>
@endsection
