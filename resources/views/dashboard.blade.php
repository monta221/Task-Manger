<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            width: 240px;
            position: fixed;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: width 0.3s ease;
        }
        .sidebar h4 {
            font-weight: 600;
            letter-spacing: 1px;
        }
        .sidebar a {
            color: white;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin: 5px 10px;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar a:hover {
            background-color: #495057;
            transform: translateX(5px);
        }

        /* Content */
        .content {
            margin-left: 240px;
            padding: 30px;
            flex: 1;
            overflow-y: auto;
            height: 100vh;
        }

        /* Sidebar footer */
        .sidebar form button {
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .sidebar form button:hover {
            transform: translateY(-2px);
        }

        /* Scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255,255,255,0.2);
            border-radius: 3px;
        }

        /* Card hover effects for content */
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>
    @php
        $currentUser = auth()->user();

        $chefProjets = $currentUser->type === 'chefprojet'
            ? \App\Models\Projet::where('chefprojet_id', $currentUser->utilisateur_id)->get()
            : collect();

        $firstProjectId = $chefProjets->first()?->projet_id ?? null;
    @endphp

    <nav class="sidebar">
        <div>
            <h4 class="text-center mb-4">Menu</h4>

            {{-- Home --}}
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill"></i>Home</a>

            @if($currentUser->type === 'profil')
                {{-- Regular user --}}
                <a href="{{ route('profil.tasks.index') }}"><i class="bi bi-list-task"></i>My Tasks</a>

            @elseif($currentUser->type === 'chefprojet')
                {{-- Chef projects --}}
                <a href="{{ route('chefprojets.index') }}"><i class="bi bi-kanban-fill"></i>My Projects</a>

                @if($firstProjectId)
                    {{-- Uncomment to link directly to first project tasks --}}
                    {{-- <a href="{{ route('chefprojets.tasks.index', $firstProjectId) }}"><i class="bi bi-list-check"></i>My Tasks</a> --}}
                @endif

            @else
                {{-- Admin & Dev --}}
                <a href="{{ route('projets.index') }}"><i class="bi bi-kanban-fill"></i>Project Management</a>

                @if(\App\Models\Projet::first())
                    {{-- <a href="{{ route('projets.taches.index', \App\Models\Projet::first()->projet_id) }}"><i class="bi bi-list-task"></i>Task Management</a> --}}
                @endif

                <a href="{{ route('profils.index') }}"><i class="bi bi-people-fill"></i>Profile Management</a>
            @endif
        </div>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST" class="m-3">
            @csrf
            <button type="submit" class="btn btn-danger w-100"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </form>
    </nav>

    <div class="content">
        {{-- Main content injected here --}}
        @yield('main-content')
    </div>
</body>
</html>
