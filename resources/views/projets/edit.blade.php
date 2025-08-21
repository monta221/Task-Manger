@extends('dashboard')

@section('main-content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Edit Project</h2>
    <a href="{{ route('projets.index') }}" class="btn btn-secondary">← Back</a>
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

    <form action="{{ route('projets.update', $projet->projet_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" class="form-control" name="titreProjet" value="{{ old('titreProjet', $projet->titreProjet) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description">{{ old('description', $projet->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" class="form-control" name="dateDebut" value="{{ old('dateDebut', $projet->dateDebut) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" class="form-control" name="dateFin" value="{{ old('dateFin', $projet->dateFin) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Note (0-20)</label>
            <input type="number" class="form-control" name="note" min="0" max="20" value="{{ old('note', $projet->note ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="etat" required>
                <option value="En attente" {{ (old('etat', $projet->etat)=='En attente') ? 'selected' : '' }}>Pending</option>
                <option value="En cours" {{ (old('etat', $projet->etat)=='En cours') ? 'selected' : '' }}>In Progress</option>
                <option value="Terminé" {{ (old('etat', $projet->etat)=='Terminé') ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('projets.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
