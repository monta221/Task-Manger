@extends('dashboard')

@section('main-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Edit Task</h2>
    <a href="{{ route('chefprojets.tasks.project', $tache->projet_id) }}" class="btn btn-secondary">← Back</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('chefprojets.update_task', [$tache->projet_id, $tache->tache_id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="titreTache" class="form-label">Title</label>
        <input type="text" name="titreTache" class="form-control" value="{{ $tache->titreTache }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control" required>{{ $tache->description }}</textarea>
    </div>

    <div class="mb-3">
        <label for="etat" class="form-label">Status</label>
        <select name="etat" class="form-control" required>
            <option value="en attente" {{ $tache->etat == 'en attente' ? 'selected' : '' }}>Pending</option>
            <option value="en cours" {{ $tache->etat == 'en cours' ? 'selected' : '' }}>In Progress</option>
            <option value="terminé" {{ $tache->etat == 'terminé' ? 'selected' : '' }}>Finished</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="utilisateur_id" class="form-label">Assign to User</label>
        <select name="utilisateur_id" class="form-control" @if(strtolower($tache->etat)=='terminé') disabled @endif>
            <option value="">-- Unassigned --</option>
            @foreach($utilisateurs as $user)
                <option value="{{ $user->utilisateur_id }}" 
                    {{ $tache->utilisateur_id == $user->utilisateur_id ? 'selected' : '' }}>
                    {{ $user->nom }} {{ $user->prenom }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="dateCreation" class="form-label">Start Date</label>
        <input type="date" name="dateCreation" class="form-control" value="{{ $tache->dateCreation }}" required>
    </div>

    <div class="mb-3">
        <label for="dateFin" class="form-label">End Date</label>
        <input type="date" name="dateFin" class="form-control" value="{{ $tache->dateFin }}">
    </div>

    <button type="submit" class="btn btn-success">Update Task</button>
    <a href="{{ route('chefprojets.tasks.project', $tache->projet_id) }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
