@extends('dashboard')

@section('main-content')
<h2>Create Task</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('projets.taches.store', $projet->projet_id) }}" method="POST">
    @csrf

<input type="hidden" name="projet_id" value="{{ $projet->projet_id }}">
<p><strong>Project:</strong> {{ $projet->titreProjet }}</p>


    <div class="mb-3">
        <label for="titreTache" class="form-label">Title</label>
        <input type="text" name="titreTache" class="form-control" value="{{ old('titreTache') }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control" required>{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="etat" class="form-label">Status</label>
        <select name="etat" class="form-control" required>
            <option value="en attente" {{ old('etat') == 'en attente' ? 'selected' : '' }}>Pending</option>
            <option value="en cours" {{ old('etat') == 'En cours' ? 'selected' : '' }}>In Progress</option>
            <option value="terminé" {{ old('etat') == 'Terminé' ? 'selected' : '' }}>Finished</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="utilisateur_id" class="form-label">Assign to User</label>
        <select name="utilisateur_id" class="form-control" required>
            <option value="">-- Select User --</option>
            @foreach($utilisateurs as $user)
                <option value="{{ $user->utilisateur_id }}" 
                    {{ old('utilisateur_id') == $user->utilisateur_id ? 'selected' : '' }}>
                    {{ $user->nom }} {{ $user->prenom }}
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
        <label class="form-label">Note (0-20)</label>
        <input type="number" name="note" class="form-control" min="0" max="20" value="{{ old('note') }}">
    </div>
    

    <button type="submit" class="btn btn-success">Save Task</button>
    <a href="{{ route('projets.index', $projet->projet_id) }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
