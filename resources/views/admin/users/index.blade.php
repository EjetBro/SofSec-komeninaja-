@extends('layout.layout')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">User List</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Role</th> <!-- Kolom baru untuk Role -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->is_banned ? 'bg-danger' : 'bg-success' }}">
                            {{ $user->is_banned ? 'Banned' : 'Active' }}
                        </span>
                    </td>
                    <td>
                        @if ($user->is_banned)
                            <form action="{{ route('admin.users.unban', $user) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Unban</button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.ban', $user) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Ban</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        @if (!$user->is_admin)
                            <form action="{{ route('admin.users.makeAdmin', $user) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">Make Admin</button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.removeAdmin', $user) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">Remove Admin</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
