@extends('dashboard')

@section('main-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Profile Management</h2>
    <a href="{{ route('profils.create') }}" class="btn btn-success">Create User</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Email</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($utilisateurs as $user)
            <tr>
                <td>{{ $user->utilisateur_id }}</td>
                <td>{{ $user->nom }}</td>
                <td>{{ $user->prenom }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->type }}</td>
                <td>
                    <a href="{{ route('profils.edit', $user->utilisateur_id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('profils.destroy', $user->utilisateur_id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No users found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
