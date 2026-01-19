@extends('layouts.app')

@section('content')
<div class="hero">
    <h1>Bonus Highlights</h1>
    <p>Filtere deine Boni und klicke auf ⓘ für mehr Details.</p>
</div>

<form method="GET" action="{{ route('home') }}" class="filters" style="margin-bottom:28px;justify-content:center;">
    <span class="filter-label">Filter:</span>
    <a class="filter-pill" href="{{ route('home') }}">
        <span {{ count($filterSlugs) ? '' : 'style=background:#f8fafc;color:#0a2a4a;' }}>Alle Boni</span>
    </a>
    @foreach($groups as $group)
        @foreach($group->options as $option)
            <label class="filter-pill">
                <input type="checkbox" name="filters[]" value="{{ $option->slug }}"
                    {{ in_array($option->slug, $filterSlugs) ? 'checked' : '' }}>
                <span>{{ $option->name }}</span>
            </label>
        @endforeach
    @endforeach
    <div style="align-self:center;">
        <button class="btn" type="submit">Anwenden</button>
    </div>
</form>

<div class="bonus-grid">
    @forelse($bonuses as $bonus)
        @php
            $methods = array_filter(array_map('trim', explode(',', $bonus->payment_methods ?? '')));
        @endphp
        <div class="flip-card" data-card>
            <div class="flip-card-inner">
                <div class="flip-card-face">
                    <div class="bonus-row">
                        <div class="bonus-brand">
                            <h3>{{ $bonus->title }}</h3>
                            @if($bonus->bonus_code)
                                <span class="bonus-code">Code → {{ $bonus->bonus_code }}</span>
                            @endif
                            @if($bonus->short_text)
                                <span>{{ $bonus->short_text }}</span>
                            @endif
                        </div>
                        <div class="bonus-metric">
                            <strong>{{ $bonus->bonus_percent ? $bonus->bonus_percent . '%' : '—' }}</strong>
                            <span>{{ $bonus->bonus_percent ? 'Bonus' : 'Bonus' }}</span>
                        </div>
                        <div class="bonus-metric">
                            <strong>{{ $bonus->max_bonus ?: '—' }}</strong>
                            <span>Maxbonus</span>
                        </div>
                        <div class="bonus-metric">
                            <strong>{{ $bonus->wager ?: '—' }}</strong>
                            <span>Wager</span>
                        </div>
                        <div style="display:flex;gap:10px;align-items:center;">
                            @if($bonus->play_url)
                                <a class="btn" href="{{ $bonus->play_url }}" target="_blank">
                                    {{ $bonus->cta_label ?: 'Play now' }}
                                </a>
                            @else
                                <span class="badge">No link yet</span>
                            @endif
                            <button class="info-btn" type="button" data-flip aria-label="More info">ⓘ</button>
                        </div>
                    </div>
                </div>
                <div class="flip-card-face flip-card-back">
                    <div>
                        <div class="card-top">
                            <h3>Information</h3>
                            <button class="info-btn" type="button" data-flip aria-label="Back">⟲</button>
                        </div>
                        <p>{{ $bonus->back_text ?: 'Keine weiteren Details vorhanden.' }}</p>
                        @if(count($methods))
                            <div class="payment-methods">
                                @foreach($methods as $method)
                                    <span class="payment-pill">{{ $method }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div style="display:flex;gap:12px;align-items:center;">
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
    @empty
        <p>No bonuses found.</p>
    @endforelse
</div>

<script>
    const cards = document.querySelectorAll('[data-card]');

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
</script>
@endsection
