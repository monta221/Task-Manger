@extends('dashboard')

@section('main-content')
<h2>Tasks for Project: {{ $projet->titreProjet }}</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('projets.taches.create', $projet->projet_id) }}" class="btn btn-primary mb-3">+ Add Task</a>
        <a href="{{ route('projets.index') }}" class="btn btn-secondary mb-3">← Back</a>
    </div>
@if($projet->taches->count() > 0)
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Assigned User</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Note</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projet->taches as $tache)
                <tr>
                    <td>{{ $tache->titreTache }}</td>
                    <td>{{ $tache->description }}</td>
                    <td>{{ $tache->utilisateur ? $tache->utilisateur->nom : '-' }}</td>
                    <td>
                        @php
                            $status = strtolower($tache->etat);
                            $badgeClass = match($status) {
                                'terminé', 'terminee' => 'bg-success',
                                'en cours' => 'bg-warning text-dark',
                                'en attente' => 'bg-secondary',
                                default => 'bg-light text-dark'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">
                            {{ ucfirst($tache->etat) }}
                        </span>
                    </td>
                    <td>{{ $tache->dateCreation }}</td>
                    <td>{{ $tache->dateFin ?? '-' }}</td>
                    <td>{{ $tache->note }}</td>
                    <td>
                        <a href="{{ route('projets.taches.edit', [$projet->projet_id, $tache->tache_id]) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('projets.taches.destroy', [$projet->projet_id, $tache->tache_id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No tasks found for this project.</p>
    
@endif
@endsection
