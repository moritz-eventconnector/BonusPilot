@extends('layouts.app')

@section('content')
<div class="admin-card" style="margin-bottom:20px;">
    <div class="admin-toolbar">
        <div>
            <h2 style="margin:0;">Filterverwaltung</h2>
            <p class="admin-muted" style="margin:6px 0 0;">Strukturiere Gruppen und Optionen für die Filterleiste auf der Startseite.</p>
        </div>
    </div>
</div>

<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
    <div class="admin-card">
        <div class="form-section">
            <h3>Neue Gruppe</h3>
            <form method="POST" action="{{ route('admin.filters.groups.store') }}">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="0">
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="is_active" value="1" checked> Aktiv</label>
                </div>
                <button class="btn" type="submit">Gruppe erstellen</button>
            </form>
        </div>
    </div>

    <div class="admin-card">
        <div class="form-section">
            <h3>Neue Option</h3>
            <form method="POST" action="{{ route('admin.filters.options.store') }}">
                @csrf
                <div class="form-group">
                    <label>Gruppe</label>
                    <select name="filter_group_id" required>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="0">
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="is_active" value="1" checked> Aktiv</label>
                </div>
                <button class="btn" type="submit">Option erstellen</button>
            </form>
        </div>
    </div>
</div>

<div class="admin-card" style="margin-top:20px;">
    <h2 style="margin-top:0;">Bestehende Filter</h2>
    @foreach($groups as $group)
        <div class="admin-card" style="margin-top:16px;">
            <form method="POST" action="{{ route('admin.filters.groups.update', $group) }}">
                @csrf
                @method('PATCH')
                <div class="admin-toolbar">
                    <div style="flex:1 1 260px;">
                        <label style="display:block;font-size:13px;color:#94a3b8;margin-bottom:6px;">Gruppenname</label>
                        <input type="text" name="name" value="{{ old('name', $group->name) }}" required>
                    </div>
                    <div style="min-width:140px;">
                        <label style="display:block;font-size:13px;color:#94a3b8;margin-bottom:6px;">Sortierung</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $group->sort_order) }}">
                    </div>
                    <div style="min-width:120px;">
                        <label style="display:block;font-size:13px;color:#94a3b8;margin-bottom:6px;">Status</label>
                        <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $group->is_active) ? 'checked' : '' }}> Aktiv</label>
                    </div>
                    <div class="admin-inline">
                        <button class="btn" type="submit">Gruppe speichern</button>
                        <button class="btn btn-secondary" type="submit" form="delete-group-{{ $group->id }}">Löschen</button>
                    </div>
                </div>
            </form>
            <form id="delete-group-{{ $group->id }}" method="POST" action="{{ route('admin.filters.groups.destroy', $group) }}">
                @csrf
                @method('DELETE')
            </form>

            <div style="margin-top:16px;">
                <h3 style="margin:0 0 12px;">Optionen</h3>
                @if($group->options->isEmpty())
                    <p class="admin-muted">Noch keine Optionen vorhanden.</p>
                @else
                    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));gap:12px;">
                        @foreach($group->options as $option)
                            <div class="card" style="margin-bottom:0;">
                                <form method="POST" action="{{ route('admin.filters.options.update', $option) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" value="{{ old('name', $option->name) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Gruppe</label>
                                        <select name="filter_group_id" required>
                                            @foreach($groups as $selectGroup)
                                                <option value="{{ $selectGroup->id }}" {{ $selectGroup->id === $option->filter_group_id ? 'selected' : '' }}>
                                                    {{ $selectGroup->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Sort Order</label>
                                        <input type="number" name="sort_order" value="{{ old('sort_order', $option->sort_order) }}">
                                    </div>
                                    <div class="form-group">
                                        <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $option->is_active) ? 'checked' : '' }}> Aktiv</label>
                                    </div>
                                    <div class="admin-inline">
                                        <button class="btn" type="submit">Option speichern</button>
                                        <button class="btn btn-secondary" type="submit" form="delete-option-{{ $option->id }}">Löschen</button>
                                    </div>
                                </form>
                                <form id="delete-option-{{ $option->id }}" method="POST" action="{{ route('admin.filters.options.destroy', $option) }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
