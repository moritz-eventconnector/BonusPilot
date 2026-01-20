@extends('layouts.app')

@php
    $title = $bonus->title;
@endphp

@section('content')
<div class="card">
    <h1>{{ $bonus->title }}</h1>
    <p><strong>{{ __('ui.bonus.casino') }}:</strong> {{ $bonus->casino_name ?? __('ui.bonus.na') }}</p>
    <p>{{ $bonus->content }}</p>
    <div class="grid grid-3">
        @if($bonus->bonus_code)
            <div><strong>{{ __('ui.bonus.code') }}:</strong> {{ $bonus->bonus_code }}</div>
        @endif
        @if($bonus->bonus_percent)
            <div><strong>{{ __('ui.bonus.percent') }}:</strong> {{ $bonus->bonus_percent }}%</div>
        @endif
        @if($bonus->max_bonus)
            <div><strong>{{ __('ui.bonus.max_bonus') }}:</strong> {{ $bonus->max_bonus }}</div>
        @endif
        @if($bonus->wager)
            <div><strong>{{ __('ui.bonus.wager') }}:</strong> {{ $bonus->wager }}</div>
        @endif
        @if($bonus->free_spins)
            <div><strong>{{ __('ui.bonus.free_spins') }}:</strong> {{ $bonus->free_spins }}</div>
        @endif
    </div>
    <div style="margin-top:16px;">
        @if($bonus->play_url)
            <a class="btn" href="{{ $bonus->play_url }}" target="_blank">{{ __('ui.bonus.play_now') }}</a>
        @endif
    </div>
</div>
@endsection
