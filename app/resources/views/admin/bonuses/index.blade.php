@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <h1>Bonuses</h1>
        <a class="btn" href="{{ route('admin.bonuses.create') }}">New Bonus</a>
    </div>
    <p>Manage bonus listings shown on the homepage.</p>
    <table class="table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Active</th>
            <th>Featured</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bonuses as $bonus)
            <tr>
                <td>{{ $bonus->title }}</td>
                <td>{{ $bonus->is_active ? 'Yes' : 'No' }}</td>
                <td>{{ $bonus->is_featured ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('admin.bonuses.edit', $bonus) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.bonuses.destroy', $bonus) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary" onclick="return confirm('Delete bonus?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $bonuses->links() }}
</div>
@endsection
