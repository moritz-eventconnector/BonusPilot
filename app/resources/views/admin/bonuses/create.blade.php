@extends('layouts.app')

@section('content')
<div class="admin-card" style="margin-bottom:20px;">
    <div class="admin-toolbar">
        <div>
            <h1 style="margin:0;">Bonus erstellen</h1>
            <p class="admin-muted" style="margin:6px 0 0;">Alle Pflichtfelder ausfüllen, damit der Bonus direkt sichtbar ist.</p>
        </div>
        <a class="btn btn-secondary" href="{{ route('admin.bonuses.index') }}">Zur Übersicht</a>
    </div>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.bonuses.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.bonuses.partials.form', ['bonus' => null, 'selectedOptions' => []])
        <div class="admin-inline" style="margin-top:16px;">
            <button class="btn" type="submit">Bonus speichern</button>
            <a class="btn btn-secondary" href="{{ route('admin.bonuses.index') }}">Abbrechen</a>
        </div>
    </form>
</div>
@endsection
