@extends('dashboard')

@section('main-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Project Management</h2>
    <a href="{{ route('projets.create') }}" class="btn btn-success">Create Project</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Chef</th>
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
        @endphp
        <tr>
            <td>{{ $projet->projet_id }}</td>
            <td>{{ $projet->chef ? $projet->chef->nom : 'Unassigned' }}</td>
            <td>{{ $projet->titreProjet }}</td>
            <td>{{ $projet->description }}</td>
            <td>{{ $projet->dateDebut }}</td>
            <td>{{ $projet->dateFin }}</td>
            <td>{{ $projet->note }}</td>

            <td>
                <span class="badge {{ $statusClass }}">{{ $dynamicStatus }}</span>
            </td>

            <td>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                        {{ round($progress) }}%
                    </div>
                </div>
            </td>

            <td>
                @if($projet->taches->count() > 0)
                <a href="{{ route('projets.taches.index', $projet->projet_id) }}" 
                   class="btn btn-sm btn-primary position-relative show-tasks-btn" 
                   data-project-id="{{ $projet->projet_id }}">
                   View Tasks
                </a>

                <div class="tasks-popout card shadow p-3 bg-white border" id="tasks-popout-{{ $projet->projet_id }}">
                    @foreach($projet->taches as $tache)
                        @php
                            $taskStatus = strtolower($tache->etat);
                            $badgeClass = match($taskStatus) {
                                'terminé', 'terminee' => 'bg-success',
                                'en cours' => 'bg-warning text-dark',
                                'en attente' => 'bg-secondary',
                                default => 'bg-light text-dark'
                            };
                        @endphp
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <strong>{{ $tache->titreTache }}</strong><br>
                                <small class="text-muted">{{ $tache->description }}</small><br>
                                <small>Assigned to: {{ $tache->utilisateur ? $tache->utilisateur->nom : '-' }}</small>
                            </div>
                            <span class="badge {{ $badgeClass }} fs-6">{{ ucfirst($tache->etat) }}</span>
                        </div>
                        <hr class="my-1">
                    @endforeach
                </div>
                @else
                    <span>No tasks</span>
                @endif
            </td>

            <td>
                <a href="{{ route('projets.edit', $projet->projet_id) }}" class="btn btn-warning btn-sm">Edit</a><br>
                <form action="{{ route('projets.destroy', $projet->projet_id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this project?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="11" class="text-center">No projects found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<style>
.tasks-popout {
    display: none;
    position: absolute;
    min-width: 300px;
    max-width: 400px;
    z-index: 9999;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    background-color: white;
    padding: 10px;
}
</style>

<script>
document.querySelectorAll('.show-tasks-btn').forEach(button => {
    const projectId = button.dataset.projectId;
    const popout = document.getElementById(`tasks-popout-${projectId}`);
    const popoutWidth = 350;

    button.addEventListener('mouseenter', (e) => {
        popout.style.display = 'block';
        popout.style.top = (e.pageY + 10) + 'px';
        popout.style.left = (e.pageX - popoutWidth - 10) + 'px';
    });

    button.addEventListener('mousemove', (e) => {
        popout.style.top = (e.pageY + 10) + 'px';
        popout.style.left = (e.pageX - popoutWidth - 10) + 'px';
    });

    button.addEventListener('mouseleave', () => {
        popout.style.display = 'none';
    });
});
</script>
@endsection
