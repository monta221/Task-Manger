<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tache;
use Illuminate\Support\Facades\Auth;

class ProfilTaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tasks = Tache::with('projet')
                     ->where('utilisateur_id', $user->utilisateur_id)
                     ->get();

        return view('profil.tasks.index', compact('tasks'));
    }

    public function updateStatus(Request $request, Tache $tache)
    {
        $request->validate([
            'etat' => 'required|in:en attente,en cours,terminé',
        ]);

        $tache->update([
            'etat' => $request->etat
        ]);

        return redirect()->route('profil.tasks.index')->with('success', 'Task status updated!');
    }
}
