@extends('layouts.app')

@section('content')
<div class="admin-card" style="margin-bottom:20px;">
    <div class="admin-toolbar">
        <div>
            <h1 style="margin:0;">Bonus bearbeiten</h1>
            <p class="admin-muted" style="margin:6px 0 0;">Änderungen speichern, damit sie auf der Website sichtbar sind.</p>
        </div>
        <a class="btn btn-secondary" href="{{ route('admin.bonuses.index') }}">Zur Übersicht</a>
    </div>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.bonuses.update', $bonus) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.bonuses.partials.form', ['bonus' => $bonus, 'selectedOptions' => $selectedOptions])
        <div class="admin-inline" style="margin-top:16px;">
            <button class="btn" type="submit">Änderungen speichern</button>
            <a class="btn btn-secondary" href="{{ route('admin.bonuses.index') }}">Abbrechen</a>
        </div>
    </form>
</div>
@endsection
