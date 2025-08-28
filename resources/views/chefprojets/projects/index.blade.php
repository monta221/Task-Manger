@extends('dashboard')

@section('main-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>My Projects</h2>
    <a href="{{ route('chefprojets.create_project') }}" class="btn btn-success">Create Project</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Note</th>
            <th>Status</th>
            <th>Progress</th>
            <th>Tasks</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($projets as $projet)
        @php
            $totalTasks = $projet->taches->count();
            $completedTasks = $projet->taches->whereIn('etat', ['terminé','terminee'])->count();
            $inProgressTasks = $projet->taches->where('etat','en cours')->count();

            $progress = $totalTasks > 0
                ? (($completedTasks * 100) + ($inProgressTasks * 50)) / $totalTasks
                : 0;

            $dynamicStatus = $progress == 100 ? 'Terminé' : ($progress == 0 ? 'En attente' : 'En cours');

            $statusClass = match($dynamicStatus) {
                'Terminé' => 'bg-success',
                'En cours' => 'bg-warning text-dark',
                'En attente' => 'bg-secondary',
                default => 'bg-light text-dark'
            };

            $progressBarClass = $progress >= 75 ? 'bg-success' : ($progress >= 25 ? 'bg-warning' : 'bg-secondary');
        @endphp
        <tr>
            <td>{{ $projet->projet_id }}</td>
            <td>{{ $projet->titreProjet }}</td>
            <td>{{ $projet->description }}</td>
            <td>{{ $projet->dateDebut }}</td>
            <td>{{ $projet->dateFin }}</td>
            <td>{{ $projet->note }}</td>
            <td><span class="badge {{ $statusClass }}">{{ $dynamicStatus }}</span></td>
            <td>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar {{ $progressBarClass }}" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                        {{ round($progress) }}%
                    </div>
                </div>
            </td>
            <td>
                <a href="{{ route('chefprojets.tasks.project', $projet->projet_id) }}" class="btn btn-sm btn-primary">View Tasks</a>
            </td>
            <td class="d-flex gap-1">
                <a href="{{ route('chefprojets.edit_project', $projet->projet_id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('chefprojets.destroy_project', $projet->projet_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this project and all its tasks?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="10" class="text-center">No projects found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
