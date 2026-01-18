@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Edit Page</h1>
    <form method="POST" action="{{ route('admin.pages.update', $page) }}">
        @csrf
        @method('PUT')
        @include('admin.pages.partials.form', ['page' => $page])
        <button class="btn" type="submit">Update</button>
    </form>
</div>
@endsection
