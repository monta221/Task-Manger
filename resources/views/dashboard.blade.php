<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { height: 100vh; margin: 0; display: flex; }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 30px;
            width: 220px;
            position: fixed;
            overflow-y: auto;

            display: flex;              
            flex-direction: column;     
            justify-content: space-between; 
        }
        .sidebar a { 
            color: white; 
            display: block; 
            padding: 12px 20px; 
            margin: 5px 0; 
            text-decoration: none; 
            border-radius: 5px; 
        }
        .sidebar a:hover { background-color: #495057; }
        .content { 
            margin-left: 220px; 
            padding: 30px; 
            flex: 1; 
            overflow-y: auto; 
            height: 100vh; 
        }
    </style>
</head>
<body>
    @php
        $currentUser = auth()->user();
        $firstProjectId = \App\Models\Projet::first()?->projet_id;
    @endphp

    <nav class="sidebar">
        <div>
            <h4 class="text-center mb-4">Menu</h4>

            <a href="{{ route('dashboard') }}">Home</a>

            @if($currentUser->type === 'profil')
                <a href="{{ route('profil.tasks.index') }}">My Tasks</a>
            @else
                @if(in_array($currentUser->type, ['admin','dev','chefprojet']))
                    <a href="{{ route('projets.index') }}">Project Management</a>
                @endif

                @if($firstProjectId)
                    <a href="{{ route('projets.taches.index', $firstProjectId) }}">Task Management</a>
                @endif

                @if(in_array($currentUser->type, ['admin','dev']))
                    <a href="{{ route('profils.index') }}">Profile Management</a>
                @endif
            @endif
        </div>

        <form action="{{ route('logout') }}" method="POST" class="m-3">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Logout</button>
        </form>
    </nav>

    <div class="content">
        @yield('main-content')
    </div>
</body>
</html>
