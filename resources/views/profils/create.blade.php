@extends('dashboard')

@section('main-content')
<div class="container mt-3">
    <h2>Create User</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profils.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" name="nom" value="{{ old('nom') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" name="prenom" value="{{ old('prenom') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Account Type</label>
            <select class="form-select" name="type" required>
                <option value="admin" {{ old('type')=='admin' ? 'selected' : '' }}>Admin</option>
                <option value="chefprojet" {{ old('type')=='chefprojet' ? 'selected' : '' }}>Project Manager</option>
                <option value="dev" {{ old('type')=='dev' ? 'selected' : '' }}>Developer</option>
                <option value="profil" {{ old('type')=='profil' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <button class="btn btn-success">Create</button>
        <a href="{{ route('profils.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
