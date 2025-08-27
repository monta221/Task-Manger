@extends('dashboard')

@section('main-content')
<h2>My Projects & Tasks</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@forelse($projets as $projet)
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ $projet->titreProjet }}</h5>
            <div>
                <a href="{{ route('chefprojets.create_task', $projet->projet_id) }}" class="btn btn-primary btn-sm">Add Task</a>
                <a href="{{ route('chefprojets.edit_project', $projet->projet_id) }}" class="btn btn-warning btn-sm">Edit Project</a>
            </div>
        </div>

        <div class="card-body">
            @if($projet->taches->count() > 0)
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
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
                        @php
                            $status = strtolower($tache->etat);
                            $badgeClass = match($status) {
                                'terminé', 'terminee' => 'bg-success',
                                'en cours' => 'bg-warning text-dark',
                                'en attente' => 'bg-secondary',
                                default => 'bg-light text-dark'
                            };
                        @endphp
                        <tr>
                            <td>{{ $tache->titreTache }}</td>
                            <td>{{ $tache->description }}</td>
                            <td>{{ $tache->utilisateur ? $tache->utilisateur->nom : '-' }}</td>
                            <td><span class="badge {{ $badgeClass }}">{{ ucfirst($tache->etat) }}</span></td>
                            <td>{{ $tache->dateCreation ?? '-' }}</td>
                            <td>{{ $tache->dateFin ?? '-' }}</td>
                            <td>
                                <a href="{{ route('chefprojets.edit_task', [$projet->projet_id, $tache->tache_id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('chefprojets.destroy_task', [$projet->projet_id, $tache->tache_id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this task?')">Delete</button>
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
@empty
    <p>No projects assigned to you.</p>
@endforelse
@endsection
