@extends('dashboard')

@section('main-content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Edit Profile</h2>
    <a href="{{ route('profils.index') }}" class="btn btn-secondary">← Back</a>
</div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profils.update', $profil->utilisateur_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" name="nom" value="{{ old('nom', $profil->nom) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" name="prenom" value="{{ old('prenom', $profil->prenom) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $profil->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Account Type</label>
            <select class="form-select" name="type" required>
                <option value="admin" {{ (old('type', $profil->type)=='admin') ? 'selected' : '' }}>Admin</option>
                <option value="chefprojet" {{ (old('type', $profil->type)=='chefprojet') ? 'selected' : '' }}>Project Manager</option>
                <option value="dev" {{ (old('type', $profil->type)=='dev') ? 'selected' : '' }}>Developer</option>
                <option value="profil" {{ (old('type', $profil->type)=='profil') ? 'profil' : '' }}>Profile</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('profils.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
