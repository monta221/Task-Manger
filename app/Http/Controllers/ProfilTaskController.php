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

    $currentStatus = strtolower($tache->etat);
    $newStatus = strtolower($request->etat);

    if ($currentStatus === 'en cours' && $newStatus === 'en attente') {
        return redirect()->back()->with('error', 'You cannot move a task from "In Progress" back to "Pending".');
    }

    $tache->update([
        'etat' => $request->etat
    ]);

    return redirect()->route('profil.tasks.index')->with('success', 'Task status updated!');
}

}
