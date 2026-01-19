@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Edit Bonus</h1>
    <form method="POST" action="{{ route('admin.bonuses.update', $bonus) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.bonuses.partials.form', ['bonus' => $bonus, 'selectedOptions' => $selectedOptions])
        <button class="btn" type="submit">Update</button>
    </form>
</div>
@endsection
