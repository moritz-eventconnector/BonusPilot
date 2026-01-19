@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Create Bonus</h1>
    <form method="POST" action="{{ route('admin.bonuses.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.bonuses.partials.form', ['bonus' => null, 'selectedOptions' => []])
        <button class="btn" type="submit">Save</button>
    </form>
</div>
@endsection
