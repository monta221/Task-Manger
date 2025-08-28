@extends('dashboard')

@section('main-content')
<div class="container mt-3">
    <h2>Create Task for Project: {{ $projet->titreProjet }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('chefprojets.store_task', $projet->projet_id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="titreTache" class="form-label">Title</label>
            <input type="text" name="titreTache" class="form-control" value="{{ old('titreTache') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="utilisateur_id" class="form-label">Assign to User</label>
            <select name="utilisateur_id" class="form-select">
                <option value="">-- Unassigned --</option>
                @foreach($utilisateurs as $user)
                    <option value="{{ $user->utilisateur_id }}" 
                        {{ old('utilisateur_id') == $user->utilisateur_id ? 'selected' : '' }}>
                        {{ $user->nom }} {{ $user->prenom }} ({{ $user->type }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="dateCreation" class="form-label">Start Date</label>
            <input type="date" name="dateCreation" class="form-control" value="{{ old('dateCreation') }}" required>
        </div>

        <div class="mb-3">
            <label for="dateFin" class="form-label">End Date</label>
            <input type="date" name="dateFin" class="form-control" value="{{ old('dateFin') }}">
        </div>

        <div class="mb-3">
            <label for="etat" class="form-label">Status</label>
            <select name="etat" class="form-select" required>
                <option value="en attente" {{ old('etat')=='en attente'?'selected':'' }}>Pending</option>
                <option value="en cours" {{ old('etat')=='en cours'?'selected':'' }}>In Progress</option>
                <option value="terminé" {{ old('etat')=='terminé'?'selected':'' }}>Finished</option>
            </select>
        </div>

        <button class="btn btn-success">Create Task</button>
        <a href="{{ route('chefprojets.tasks.project', $projet->projet_id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
