@extends('layouts.app')

@section('content')
<<<<<<< HEAD
<div class="hero">
    <h1>Top Casino Bonuses</h1>
    <p>Explore featured offers and filter by bonus type. Click ⓘ for more details.</p>
</div>

<form method="GET" action="{{ route('home') }}" class="filters" style="margin-bottom:24px;">
=======
<h1>Bonuses</h1>

<form method="GET" action="{{ route('home') }}" class="filters">
>>>>>>> origin/main
    @foreach($groups as $group)
        <div class="filter-group">
            <strong>{{ $group->name }}</strong>
            @foreach($group->options as $option)
                <label style="display:block;margin-top:6px;">
                    <input type="checkbox" name="filters[]" value="{{ $option->slug }}"
                        {{ in_array($option->slug, $filterSlugs) ? 'checked' : '' }}>
                    {{ $option->name }}
                </label>
            @endforeach
        </div>
    @endforeach
    <div style="align-self:flex-end;">
        <button class="btn" type="submit">Apply Filters</button>
    </div>
</form>

<<<<<<< HEAD
<div class="bonus-grid">
    @forelse($bonuses as $bonus)
        @php
            $methods = array_filter(array_map('trim', explode(',', $bonus->payment_methods ?? '')));
        @endphp
        <div class="flip-card" data-card>
            <div class="flip-card-inner">
                <div class="flip-card-face">
                    <div>
                        <div class="card-top">
                            <div>
                                <h3>{{ $bonus->title }}</h3>
                                <p>{{ $bonus->short_text }}</p>
                            </div>
                            <button class="info-btn" type="button" data-flip aria-label="More info">ⓘ</button>
                        </div>
                        @if($bonus->bonus_percent)
                            <p><strong>{{ $bonus->bonus_percent }}%</strong> bonus</p>
                        @endif
                        @if($bonus->bonus_code)
                            <p><strong>Code:</strong> {{ $bonus->bonus_code }}</p>
                        @endif
                        @if($bonus->is_featured)
                            <span class="badge">Featured</span>
                        @endif
                    </div>
                    <div>
                        @if($bonus->play_url)
                            <a class="btn" href="{{ $bonus->play_url }}" target="_blank">
                                {{ $bonus->cta_label ?: 'Claim Bonus' }}
                            </a>
                        @else
                            <span class="badge">No link yet</span>
                        @endif
                    </div>
                </div>
                <div class="flip-card-face flip-card-back">
                    <div>
                        <div class="card-top">
                            <h3>More Info</h3>
                            <button class="info-btn" type="button" data-flip aria-label="Back">⟲</button>
                        </div>
                        <p>{{ $bonus->back_text ?: 'No additional details yet.' }}</p>
                        @if(count($methods))
                            <div class="payment-methods">
                                @foreach($methods as $method)
                                    <span class="payment-pill">{{ $method }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div>
                        @if($bonus->terms_url)
                            <a class="btn btn-outline" href="{{ $bonus->terms_url }}" target="_blank">Full Terms</a>
                        @endif
                    </div>
                </div>
=======
<div class="grid grid-3" style="margin-top:24px;">
    @forelse($bonuses as $bonus)
        <div class="card">
            <h3>{{ $bonus->title }}</h3>
            <p>{{ $bonus->short_text }}</p>
            @if($bonus->bonus_percent)
                <p><strong>{{ $bonus->bonus_percent }}%</strong> bonus</p>
            @endif
            @if($bonus->is_featured)
                <span class="badge">Featured</span>
            @endif
            <div style="margin-top:12px;">
                <a class="btn" href="{{ route('bonus.show', $bonus->slug) }}">View Bonus</a>
>>>>>>> origin/main
            </div>
        </div>
    @empty
        <p>No bonuses found.</p>
    @endforelse
</div>
<<<<<<< HEAD

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
=======
>>>>>>> origin/main
@endsection
