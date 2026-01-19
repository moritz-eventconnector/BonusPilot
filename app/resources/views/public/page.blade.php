@extends('layouts.app')

@php
    $title = $page->seo_title ?: $page->title;
@endphp

@section('content')
<div class="card">
    <h1>{{ $page->title }}</h1>
    <div>{!! $page->content !!}</div>
</div>
@endsection
