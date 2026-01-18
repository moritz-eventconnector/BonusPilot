@extends('layouts.app')

@section('content')
<div class="card">
    <h1>{{ $page->title }}</h1>
    <div>{!! $page->content !!}</div>
</div>
@endsection
