@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Create Page</h1>
    <form method="POST" action="{{ route('admin.pages.store') }}">
        @csrf
        @include('admin.pages.partials.form', ['page' => null])
        <button class="btn" type="submit">Save</button>
    </form>
</div>
@endsection
