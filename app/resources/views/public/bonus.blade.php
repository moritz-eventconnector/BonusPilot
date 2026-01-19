@extends('layouts.app')

@section('content')
<div class="card">
    <h1>{{ $bonus->title }}</h1>
    <p><strong>Casino:</strong> {{ $bonus->casino_name ?? 'N/A' }}</p>
    <p>{{ $bonus->content }}</p>
    <div class="grid grid-3">
        @if($bonus->bonus_code)
            <div><strong>Code:</strong> {{ $bonus->bonus_code }}</div>
        @endif
        @if($bonus->bonus_percent)
            <div><strong>Percent:</strong> {{ $bonus->bonus_percent }}%</div>
        @endif
        @if($bonus->max_bonus)
            <div><strong>Max Bonus:</strong> {{ $bonus->max_bonus }}</div>
        @endif
        @if($bonus->wager)
            <div><strong>Wager:</strong> {{ $bonus->wager }}</div>
        @endif
        @if($bonus->free_spins)
            <div><strong>Free Spins:</strong> {{ $bonus->free_spins }}</div>
        @endif
    </div>
    <div style="margin-top:16px;">
        @if($bonus->play_url)
            <a class="btn" href="{{ $bonus->play_url }}" target="_blank">Play Now</a>
        @endif
    </div>
</div>
@endsection
