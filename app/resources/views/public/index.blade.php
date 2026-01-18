@extends('layouts.app')

@section('content')
<h1>Bonuses</h1>

<form method="GET" action="{{ route('home') }}" class="filters">
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
            </div>
        </div>
    @empty
        <p>No bonuses found.</p>
    @endforelse
</div>
@endsection
