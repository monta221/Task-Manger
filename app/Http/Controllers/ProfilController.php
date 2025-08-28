<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{

    public function index()
    {
        $utilisateurs = Utilisateur::all();
        return view('profils.index', compact('utilisateurs'));
    }
    public function create()
    {
        return view('profils.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|string|min:6',
            'type' => 'required|in:admin,chefprojet,dev,profil',
        ]);

        Utilisateur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
        ]);

        return redirect()->route('profils.index')->with('success', 'Utilisateur créé !');
    }

    public function show(Utilisateur $profil)
    {
        return view('profils.show', compact('profil'));
    }
    public function edit(Utilisateur $profil)
    {
        return view('profils.edit', compact('profil'));
    }
    public function update(Request $request, Utilisateur $profil)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email,'.$profil->utilisateur_id.',utilisateur_id',
            'type' => 'required|in:admin,chefprojet,dev,profil',
        ]);

        $profil->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'type' => $request->type,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    public function destroy(Utilisateur $profil)
    {
        $tasksCount = $profil->taches()->count();
        $projectsCount = $profil->chefProjets()->count();

        if ($tasksCount > 0 || $projectsCount > 0) {
            return redirect()->back()->with('error', 'Cannot delete this user because they are assigned to tasks or projects.');
        }

        $profil->delete();

        return redirect()->route('profils.index')->with('success', 'Utilisateur supprimé !');
    }
}
