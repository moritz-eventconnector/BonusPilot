@extends('layouts.app')

@section('content')
<div class="grid grid-3">
    <div class="card">
        <h2>Create Filter Group</h2>
<<<<<<< HEAD
        <p>Groups appear on the homepage filter bar.</p>
=======
>>>>>>> origin/main
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
<<<<<<< HEAD
        <p>Options belong to a group and can be assigned to bonuses.</p>
=======
>>>>>>> origin/main
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
        <h3>{{ $group->name }}</h3>
        <div>
            @foreach($group->options as $option)
                <span class="badge">{{ $option->name }}</span>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
