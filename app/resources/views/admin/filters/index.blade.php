@extends('layouts.app')

@section('content')
<div class="grid grid-3">
    <div class="card">
        <h2>Create Filter Group</h2>
        <p>Groups appear on the homepage filter bar.</p>
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
                <label><input type="checkbox" name="is_active" value="1" checked> Active</label>
            </div>
            <button class="btn" type="submit">Create Group</button>
        </form>
    </div>

    <div class="card">
        <h2>Create Filter Option</h2>
        <p>Options belong to a group and can be assigned to bonuses.</p>
        <form method="POST" action="{{ route('admin.filters.options.store') }}">
            @csrf
            <div class="form-group">
                <label>Group</label>
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
                <label><input type="checkbox" name="is_active" value="1" checked> Active</label>
            </div>
            <button class="btn" type="submit">Create Option</button>
        </form>
    </div>
</div>

<div class="card">
    <h2>Existing Filters</h2>
    @foreach($groups as $group)
        <div class="card" style="margin-top:16px;">
            <form method="POST" action="{{ route('admin.filters.groups.update', $group) }}">
                @csrf
                @method('PATCH')
                <div class="grid grid-3">
                    <div class="form-group">
                        <label>Group Name</label>
                        <input type="text" name="name" value="{{ old('name', $group->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $group->sort_order) }}">
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $group->is_active) ? 'checked' : '' }}> Active</label>
                    </div>
                </div>
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <button class="btn" type="submit">Update Group</button>
                    <button class="btn btn-secondary" type="submit" form="delete-group-{{ $group->id }}">Delete Group</button>
                </div>
            </form>
            <form id="delete-group-{{ $group->id }}" method="POST" action="{{ route('admin.filters.groups.destroy', $group) }}">
                @csrf
                @method('DELETE')
            </form>
            <h3 style="margin-top:16px;">Options</h3>
            <div class="grid grid-3">
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
                                <label>Group</label>
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
                                <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $option->is_active) ? 'checked' : '' }}> Active</label>
                            </div>
                            <div style="display:flex;gap:12px;flex-wrap:wrap;">
                                <button class="btn" type="submit">Update Option</button>
                                <button class="btn btn-secondary" type="submit" form="delete-option-{{ $option->id }}">Delete Option</button>
                            </div>
                        </form>
                        <form id="delete-option-{{ $option->id }}" method="POST" action="{{ route('admin.filters.options.destroy', $option) }}">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endforeach
            </div>
            @if($group->options->isEmpty())
                <p>No options yet.</p>
            @endif
        </div>
    @endforeach
</div>
@endsection
