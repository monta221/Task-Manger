@extends('dashboard')

@section('main-content')
<h2>My Tasks</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="list-group">
    @forelse($tasks as $task)
        <div class="list-group-item mb-2 d-flex justify-content-between align-items-center shadow-sm">
            <div>
                <h5>{{ $task->titreTache }}</h5>
                <p>{{ $task->description }}</p>
                <small>Project: {{ $task->projet->titreProjet }}</small>
            </div>

            <div class="d-flex flex-column align-items-end">
                <form action="{{ route('profil.tasks.update-status', $task->tache_id) }}" method="POST" class="mb-2">
                    @csrf
                    @method('PUT')
                    <select name="etat" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="en attente" 
                            {{ $task->etat=='en attente' ? 'selected' : '' }}
                            {{ $task->etat=='en cours' ? 'disabled' : '' }}>
                            Pending
                        </option>
                        <option value="en cours" {{ $task->etat=='en cours' ? 'selected' : '' }}>In Progress</option>
                        <option value="terminé" {{ $task->etat=='terminé' ? 'selected' : '' }}>Finished</option>
                    </select>
                </form>

                <span class="badge 
                    {{ $task->etat=='terminé' ? 'bg-success' : ($task->etat=='en cours' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                    {{ ucfirst($task->etat) }}
                </span>
            </div>
        </div>
    @empty
        <p>You have no tasks assigned.</p>
    @endforelse
</div>  
@endsection
