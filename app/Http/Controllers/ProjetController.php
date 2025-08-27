<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    public function index()
    {
        // Load projects with chef and tasks
        $projets = Projet::with('chef', 'taches.utilisateur')->get();
        return view('projets.index', compact('projets'));
    }

    public function create()
    {
        $chefs = Utilisateur::where('type', 'chefprojet')->get();
        return view('projets.create', compact('chefs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titreProjet' => 'required|string|max:255',
            'description' => 'nullable|string',
            'dateDebut' => 'required|date',
            'dateFin' => 'nullable|date|after_or_equal:dateDebut',
            'note' => 'nullable|integer|between:0,20',
            'etat' => 'required|in:En attente,En cours,Terminé',
            'chefprojet_id' => 'nullable|exists:utilisateurs,utilisateur_id',
        ]);

        Projet::create($validated);

        return redirect()->route('projets.index')->with('success', 'Project created successfully!');
    }

    public function edit(Projet $projet)
    {
        $chefs = Utilisateur::where('type', 'chefprojet')->get();
        return view('projets.edit', compact('projet', 'chefs'));
    }

    public function update(Request $request, Projet $projet)
    {
        $validated = $request->validate([
            'titreProjet' => 'required|string|max:255',
            'description' => 'nullable|string',
            'dateDebut' => 'required|date',
            'dateFin' => 'nullable|date|after_or_equal:dateDebut',
            'note' => 'nullable|integer|between:0,20',
            'etat' => 'required|in:En attente,En cours,Terminé',
            'chefprojet_id' => 'nullable|exists:utilisateurs,utilisateur_id',
        ]);

        $projet->update($validated);

        return redirect()->route('projets.index')->with('success', 'Project updated successfully!');
    }

    public function destroy(Projet $projet)
    {
        $projet->delete();
        return redirect()->route('projets.index')->with('success', 'Project deleted successfully!');
    }
    public function showTasks(Projet $projet)
    {
        $projet->load('taches.utilisateur');
        return view('projets.tasks', compact('projet'));
    }

}
