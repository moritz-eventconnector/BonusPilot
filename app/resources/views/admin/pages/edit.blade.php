@extends('layouts.app')

@section('content')
<div class="card">
    <h1>{{ __('ui.pages.edit_title') }}</h1>
    <form method="POST" action="{{ route('admin.pages.update', $page) }}">
        @csrf
        @method('PUT')
        @include('admin.pages.partials.form', ['page' => $page])
        <button class="btn" type="submit">{{ __('ui.common.update') }}</button>
    </form>
</div>
@endsection
