@extends('layouts.app')

@section('content')
<div class="card">
    <h1>{{ __('ui.pages.create_title') }}</h1>
    <form method="POST" action="{{ route('admin.pages.store') }}">
        @csrf
        @include('admin.pages.partials.form', ['page' => null])
        <button class="btn" type="submit">{{ __('ui.common.save') }}</button>
    </form>
</div>
@endsection
