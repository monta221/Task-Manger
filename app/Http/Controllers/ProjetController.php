<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    public function index()
    {
        $projets = Projet::all();
        return view('projets.index', compact('projets'));
    }

    public function create()
    {
        return view('projets.create');
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
        ]);

        Projet::create($validated);

        return redirect()->route('projets.index')->with('success', 'Project created successfully !');
    }

    public function show(Projet $projet)
    {
        return view('projets.show', compact('projet'));
    }

    public function edit(Projet $projet)
    {
        return view('projets.edit', compact('projet'));
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
        ]);

        $projet->update($validated);

        return redirect()->back()->with('success', 'Project updated successfully!');
    }

    public function destroy(Projet $projet)
    {
        $projet->delete();
        return redirect()->route('projets.index')->with('success', 'Project deleted successfully!');
    }
}
