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
        $projets = Projet::where('chefprojet_id', auth()->id())
            ->with('taches.utilisateur')
            ->get();

        return view('chefprojets.projects.index', compact('projets'));
    }

    private function authorizeProject(Projet $projet)
    {
        if ($projet->chefprojet_id !== auth()->id()) abort(403, "Unauthorized");
    }

    private function validateProject(Request $request)
    {
        return $request->validate([
            'titreProjet' => 'required|string|max:255',
            'description' => 'nullable|string',
            'dateDebut' => 'required|date',
            'dateFin' => 'nullable|date|after_or_equal:dateDebut',
            'note' => 'nullable|integer|between:0,20',
            'etat' => 'required|in:En attente,En cours,Terminé',
        ]);
    }

    public function createProject() { return view('chefprojets.projects.create'); }

    public function storeProject(Request $request)
    {
        $data = $this->validateProject($request);
        $data['chefprojet_id'] = auth()->id();
        $projet = Projet::create($data);

        return redirect()->route('chefprojets.tasks.project', $projet->projet_id)
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
        $projet->update($this->validateProject($request));

        return redirect()->route('chefprojets.tasks.project', $projet->projet_id)
                         ->with('success', 'Project updated successfully!');
    }

    public function destroyProject(Projet $projet)
    {
        $this->authorizeProject($projet);
        $projet->taches()->delete();
        $projet->delete();

        return redirect()->route('chefprojets.index')->with('success', 'Project deleted successfully!');
    }

    private function validateTask(Request $request)
    {
        return $request->validate([
            'titreTache' => 'required|string|max:255',
            'description' => 'nullable|string',
            'utilisateur_id' => 'nullable|exists:utilisateurs,utilisateur_id',
            'etat' => 'required|in:en attente,en cours,terminé',
            'dateCreation' => 'required|date',
            'dateFin' => 'nullable|date|after_or_equal:dateCreation',
        ]);
    }

    public function createTask(Projet $projet)
    {
        $this->authorizeProject($projet);
        $utilisateurs = Utilisateur::whereIn('type', ['profil'])->get();

        return view('chefprojets.tasks.create', compact('projet', 'utilisateurs'));
    }

    public function storeTask(Request $request, Projet $projet)
    {
        $this->authorizeProject($projet);
        $data = $this->validateTask($request);
        $data['projet_id'] = $projet->projet_id;
        Tache::create($data);

        return redirect()->route('chefprojets.tasks.project', $projet->projet_id)
                         ->with('success', 'Task created successfully!');
    }

    public function editTask($projet_id, $tache_id)
    {
        $projet = Projet::findOrFail($projet_id);
        $this->authorizeProject($projet);

        $tache = Tache::findOrFail($tache_id);
        $utilisateurs = Utilisateur::whereIn('type',['profil'])->get();

        return view('chefprojets.tasks.edit', compact('projet','tache','utilisateurs'));
    }

    public function updateTask(Request $request, $projet_id, $tache_id)
    {
        $projet = Projet::findOrFail($projet_id);
        $this->authorizeProject($projet);

        $tache = Tache::findOrFail($tache_id);
        $data = $this->validateTask($request);

        if (strtolower($tache->etat) === 'terminé') unset($data['utilisateur_id']);

        $tache->update($data);

        return redirect()->route('chefprojets.tasks.project', $projet->projet_id)
                         ->with('success', 'Task updated successfully!');
    }

    public function destroyTask($projet_id, $tache_id)
    {
        $projet = Projet::findOrFail($projet_id);
        $this->authorizeProject($projet);

        $tache = Tache::findOrFail($tache_id);
        if (!in_array(strtolower($tache->etat), ['en attente', 'terminé'])) {
            return redirect()->route('chefprojets.tasks.project', $projet->projet_id)
                                ->with('error', 'Cannot delete task in progress.');
        }

        $tache->delete();

        return redirect()->route('chefprojets.tasks.project', $projet->projet_id)
                         ->with('success', 'Task deleted successfully!');
    }

    public function projectTasks(Projet $projet)
    {
        $this->authorizeProject($projet);
        $projet->load('taches.utilisateur');

        return view('chefprojets.tasks.project', compact('projet'));
    }
}
