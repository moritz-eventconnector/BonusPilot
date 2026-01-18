@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <h1>Pages</h1>
        <a class="btn" href="{{ route('admin.pages.create') }}">New Page</a>
    </div>
<<<<<<< HEAD
    <p>Publish informational pages shown under /p/{slug}.</p>
=======
>>>>>>> origin/main
    <table class="table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pages as $page)
            <tr>
                <td>{{ $page->title }}</td>
                <td>{{ ucfirst($page->status) }}</td>
                <td>
                    <a href="{{ route('admin.pages.edit', $page) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-secondary" type="submit" onclick="return confirm('Delete page?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $pages->links() }}
</div>
@endsection
