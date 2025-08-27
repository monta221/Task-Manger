@extends('dashboard')

@section('main-content')
<div class="container mt-3">
    <h2>Create Project</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('chefprojets.store_project') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="titreProjet" class="form-control" value="{{ old('titreProjet') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" name="dateDebut" class="form-control" value="{{ old('dateDebut') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" name="dateFin" class="form-control" value="{{ old('dateFin') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Note (0-20)</label>
            <input type="number" name="note" class="form-control" min="0" max="20" value="{{ old('note') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="etat" class="form-select" required>
                <option value="En attente" {{ old('etat')=='En attente' ? 'selected':'' }}>Pending</option>
                <option value="En cours" {{ old('etat')=='En cours' ? 'selected':'' }}>In Progress</option>
                <option value="Terminé" {{ old('etat')=='Terminé' ? 'selected':'' }}>Completed</option>
            </select>
        </div>

        <button class="btn btn-success">Create</button>
        <a href="{{ route('chefprojets.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
