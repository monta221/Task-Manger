@extends('dashboard')

@section('main-content')
<h2>Task Management</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@foreach($projets as $projet)
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ $projet->titreProjet }}</h5>
            <a href="{{ route('projets.taches.create', $projet->projet_id) }}" class="btn btn-primary btn-sm">Add Task</a>
        </div>
        <div class="card-body">
            @if($projet->taches->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Assigned User</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
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
                <p>No tasks for this project.</p>
            @endif
        </div>
    </div>
@endforeach
@endsection
