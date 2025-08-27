@extends('dashboard')

@section('main-content')
<div class="container mt-5">
    <div class="row align-items-center text-center text-md-start mb-5">
        <div class="col-md-6">
            <h1 class="display-4 fw-bold animate__animated animate__fadeInLeft">
                Welcome to Task Manager
            </h1>
            <p class="lead text-muted animate__animated animate__fadeInLeft animate__delay-1s">
                Plan, organize, and track all your team’s tasks effortlessly.
            </p>
            <div class="mt-3">
                @if(auth()->user()->type == 'chefprojet')
                    <a href="{{ route('chefprojets.create_project') }}" class="btn btn-primary btn-lg me-2 animate__animated animate__fadeInUp animate__delay-2s">
                        Create Project
                    </a>
                    <a href="{{ route('chefprojets.index') }}" class="btn btn-outline-primary btn-lg animate__animated animate__fadeInUp animate__delay-2s">
                        View Projects
                    </a>
                @elseif(auth()->user()->type == 'admin')
                    <a href="{{ route('projets.create') }}" class="btn btn-primary btn-lg me-2 animate__animated animate__fadeInUp animate__delay-2s">
                        Create Project
                    </a>
                    <a href="{{ route('projets.index') }}" class="btn btn-outline-primary btn-lg animate__animated animate__fadeInUp animate__delay-2s">
                        View Projects
                    </a>
                @else
                    <a href="{{ route('profil.tasks.index') }}" class="btn btn-primary btn-lg animate__animated animate__fadeInUp animate__delay-2s">
                        My Tasks
                    </a>
                @endif
            </div>
        </div>
        <div class="col-md-6 text-center animate__animated animate__fadeInRight">
            <img src="https://cdn-icons-png.flaticon.com/512/3115/3115715.png" 
                 class="img-fluid" 
                 alt="Task Management Illustration" style="max-height: 350px;">
        </div>
    </div>

    <div class="row text-center mb-5">
        @php
            $features = [
                ['icon'=>'bi-kanban-fill','title'=>'Organize Projects','text'=>'Keep your projects structured and easy to manage.','color'=>'primary'],
                ['icon'=>'bi-person-check-fill','title'=>'Assign Tasks','text'=>'Assign tasks and follow up on your team’s progress.','color'=>'success'],
                ['icon'=>'bi-bar-chart-line-fill','title'=>'Track Progress','text'=>'Visualize task completion easily and efficiently.','color'=>'warning'],
            ];
        @endphp

        @foreach($features as $feature)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 feature-card p-4">
                <i class="bi {{ $feature['icon'] }} fs-1 text-{{ $feature['color'] }} mb-3"></i>
                <h5 class="card-title">{{ $feature['title'] }}</h5>
                <p class="card-text text-muted">{{ $feature['text'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-5">
        <h2 class="fw-bold animate__animated animate__fadeInUp">Boost Your Team Productivity Today!</h2>
        <p class="text-muted animate__animated animate__fadeInUp animate__delay-1s">
            Start organizing, assigning, and tracking tasks in a smarter way.
        </p>
        @if(auth()->user()->type == 'chefprojet')
            <a href="{{ route('chefprojets.create_project') }}" class="btn btn-primary btn-lg mt-3 animate__animated animate__fadeInUp animate__delay-2s">
                Create Your First Project
            </a>
        @elseif(auth()->user()->type == 'admin')
            <a href="{{ route('projets.create') }}" class="btn btn-primary btn-lg mt-3 animate__animated animate__fadeInUp animate__delay-2s">
                Create Your First Project
            </a>
        @else
            <a href="{{ route('profil.tasks.index') }}" class="btn btn-primary btn-lg mt-3 animate__animated animate__fadeInUp animate__delay-2s">
                View My Tasks
            </a>
        @endif
    </div>

</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
.feature-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: default;
}
.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}
</style>
@endsection
