@extends('layouts.app')

@php
    $title = $page->seo_title ?: $page->title;
@endphp

@section('content')
<div class="card">
    <h1 class="page-title page-title--{{ $page->title_alignment ?? 'left' }}">{{ $page->title }}</h1>
    <div>{!! $page->content !!}</div>
</div>
@endsection
