<?php
namespace App\Http\Controllers;

use App\Models\Tache;
use App\Models\Projet;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function index()
    {
        $projets = Projet::with('taches.utilisateur')->get();
        return view('taches.index', compact('projets'));
    }

    public function create(Projet $projet)
    {
        $utilisateurs = Utilisateur::all(); 
        return view('taches.create', compact('projet', 'utilisateurs'));
    }

    public function store(Request $request, Projet $projet)
    {
        $validated = $request->validate([
            'projet_id'=> 'required|exists:projets,projet_id', 
            'titreTache'=> 'required|string|max:255',
            'description'=> 'nullable|string',
            'etat'=> 'required|in:en attente,en cours,terminé',
            'utilisateur_id'=> 'nullable|exists:utilisateurs,utilisateur_id',
            'dateCreation'=> 'required|date',
            'dateFin'=> 'nullable|date|after_or_equal:dateCreation',
            'note'=> 'nullable|integer|between:0,20',
        ]);

        $validated['projet_id'] = $projet->projet_id; 
        Tache::create($validated);

        return redirect()->route('projets.taches.index', $validated['projet_id'])
                         ->with('success', 'Task created successfully!');
    }

    public function edit(Projet $projet, Tache $tache)
    {
        $projets = Projet::all();
        $utilisateurs = Utilisateur::all();
        return view('taches.edit', compact('projet', 'tache', 'projets', 'utilisateurs'));
    }

    public function update(Request $request, Projet $projet, Tache $tache)
    {
        $validated = $request->validate([
            'projet_id'=> 'required|exists:projets,projet_id', 
            'titreTache'=> 'required|string|max:255',
            'description'=> 'nullable|string',
            'etat'=> 'required|in:en attente,en cours,terminé',
            'utilisateur_id'=> 'nullable|exists:utilisateurs,utilisateur_id',
            'dateCreation'=> 'required|date',
            'dateFin'=> 'nullable|date|after_or_equal:dateCreation',
            'note'=> 'nullable|integer|between:0,20',
        ]);

        if ($tache->etat === 'terminé') {
            unset($validated['utilisateur_id']);
        }

        if ($tache->etat === 'en cours' && $validated['etat'] === 'en attente') {
            return redirect()->back()->with('error', 'Cannot move a task from In Progress back to Pending.');
        }

        $tache->update($validated);

        return redirect()->back()->with('success', 'Task updated successfully!');
    }

    public function destroy(Projet $projet, Tache $tache)
    {
        if (!in_array(strtolower($tache->etat), ['en attente', 'terminé'])) {
            return back()->with('error', 'Only tasks with status "Pending" or "Finished" can be deleted.');
        }

        $tache->delete();

        return redirect()->route('projets.taches.index', $projet->projet_id)
                         ->with('success', 'Task deleted successfully!');
    }
}
