<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Tache;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class ChefProjetController extends Controller
{
    public function projectsIndex()
    {
        $chefId = auth()->id();
        $projets = Projet::where('chefprojet_id', $chefId)
            ->with('taches.utilisateur')
            ->get();

        return view('chefprojets.projects.index', compact('projets'));
    }

    private function authorizeProject(Projet $projet)
    {
        if ($projet->chefprojet_id !== auth()->id()) {
            abort(403, "You don't have permission to access this project.");
        }
    }

    public function createProject()
    {
        return view('chefprojets.projects.create');
    }

    public function storeProject(Request $request)
    {
        $validated = $request->validate([
            'titreProjet' => 'required|string|max:255',
            'description' => 'nullable|string',
            'dateDebut' => 'required|date',
            'dateFin' => 'nullable|date|after_or_equal:dateDebut',
            'note' => 'nullable|integer|between:0,20',
            'etat' => 'required|in:En attente,En cours,Terminé',
        ]);

        $validated['chefprojet_id'] = auth()->id();

        Projet::create($validated);

        return redirect()->route('chefprojets.index')
                         ->with('success', 'Project created successfully!');
    }

    public function editProject(Projet $projet)
    {
        $this->authorizeProject($projet);
        return view('chefprojets.projects.edit', compact('projet'));
    }

    public function updateProject(Request $request, Projet $projet)
    {
        $this->authorizeProject($projet);

        $validated = $request->validate([
            'titreProjet' => 'required|string|max:255',
            'description' => 'nullable|string',
            'dateDebut' => 'required|date',
            'dateFin' => 'nullable|date|after_or_equal:dateDebut',
            'note' => 'nullable|integer|between:0,20',
            'etat' => 'required|in:En attente,En cours,Terminé',
        ]);

        $projet->update($validated);

        return back()->with('success', 'project updated successfully!');
    }

    public function tasksIndex()
    {
        $chefId = auth()->id();

        $projets = Projet::where('chefprojet_id', $chefId)
                         ->with('taches.utilisateur')
                         ->get();
        return view('chefprojets.tasks.index', compact('projets'));
    }
    
    public function createTask(Projet $projet)
    {   
        $this->authorizeProject($projet);

        $utilisateurs = Utilisateur::whereIn('type', ['dev','profil'])->get();

        return view('chefprojets.tasks.create', compact('projet', 'utilisateurs'));
    }


    public function storeTask(Request $request, Projet $projet)
    {
        $this->authorizeProject($projet);

        $validated = $request->validate([
            'titreTache' => 'required|string|max:255',
            'description' => 'nullable|string',
            'utilisateur_id' => 'nullable|exists:utilisateurs,utilisateur_id',
            'etat' => 'required|in:en attente,en cours,terminé',
            'dateCreation' => 'required|date',
            'dateFin' => 'nullable|date|after_or_equal:dateCreation',
        ]);

        $validated['projet_id'] = $projet->projet_id;

        Tache::create($validated);

        return redirect()->route('chefprojets.index')
                         ->with('success', 'Task created successfully!');
    }

    public function editTask($projet_id, $tache_id)
    {
        $projet = Projet::findOrFail($projet_id);
        $this->authorizeProject($projet);

        $tache = Tache::findOrFail($tache_id);
        $utilisateurs = Utilisateur::whereIn('type',['dev','profil'])->get();

        $projets = Projet::where('chefprojet_id', auth()->id())->get();

        return view('chefprojets.tasks.edit', compact('projet','tache','utilisateurs','projets'));
    }


    public function updateTask(Request $request, $projet_id, $tache_id)
    {
        $projet = Projet::findOrFail($projet_id);
        $this->authorizeProject($projet);

        $tache = Tache::findOrFail($tache_id);

        $validated = $request->validate([
            'titreTache' => 'required|string|max:255',
            'description' => 'nullable|string',
            'utilisateur_id' => 'nullable|exists:utilisateurs,utilisateur_id',
            'etat' => 'required|in:en attente,en cours,terminé',
            'dateCreation' => 'required|date',
            'dateFin' => 'nullable|date|after_or_equal:dateCreation',
        ]);

        $tache->update($validated);

        return back()->with('success', 'Task updated successfully!');

    }

    public function destroyTask($projet_id, $tache_id)
    {
        $projet = Projet::findOrFail($projet_id);
        $this->authorizeProject($projet);

        $tache = Tache::findOrFail($tache_id);
        $tache->delete();

        return redirect()->route('chefprojets.index')
                         ->with('success','Task deleted successfully!');
    }
    public function projectTasks(Projet $projet)
    {
        $this->authorizeProject($projet);

        $projet->load('taches.utilisateur');

        return view('chefprojets.tasks.project', compact('projet'));
    }

}
