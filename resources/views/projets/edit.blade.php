@extends('dashboard')

@section('main-content')
<div class="container mt-3">
    <h2>Edit Project</h2>
    <a href="{{ route('projets.index') }}" class="btn btn-secondary mb-3">← Back</a>

    @if($errors->any())
        <div class="alert alert-danger"><ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>
    @endif

    <form action="{{ route('projets.update', $projet->projet_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="titreProjet" class="form-control" value="{{ old('titreProjet', $projet->titreProjet) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $projet->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" name="dateDebut" class="form-control" value="{{ old('dateDebut', $projet->dateDebut) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" name="dateFin" class="form-control" value="{{ old('dateFin', $projet->dateFin) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Note (0-20)</label>
            <input type="number" name="note" class="form-control" min="0" max="20" value="{{ old('note', $projet->note) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="etat" class="form-select" required>
                <option value="En attente" {{ old('etat', $projet->etat)=='En attente' ? 'selected' : '' }}>Pending</option>
                <option value="En cours" {{ old('etat', $projet->etat)=='En cours' ? 'selected' : '' }}>In Progress</option>
                <option value="Terminé" {{ old('etat', $projet->etat)=='Terminé' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Chef Project</label>
            <select class="form-select" name="chefprojet_id">
                <option value="">-- Select Chef --</option>
                @foreach(\App\Models\Utilisateur::where('type', 'chefprojet')->get() as $chef)
                    <option value="{{ $chef->utilisateur_id }}"
                        {{ old('chefprojet_id', $projet->chefprojet_id ?? '') == $chef->utilisateur_id ? 'selected' : '' }}>
                        {{ $chef->nom }} {{ $chef->prenom }}
                    </option>
                @endforeach
            </select>
        </div>


        <button class="btn btn-primary">Update</button>
        <a href="{{ route('projets.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
