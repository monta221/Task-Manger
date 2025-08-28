<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProfilTaskController;
use App\Http\Controllers\ChefProjetController;

// Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/home', function() {
    return view('welcome');
})->name('dashboard');

// Admin & Dev
Route::resource('projets', ProjetController::class);
Route::resource('profils', ProfilController::class);
Route::prefix('projets/{projet}')->group(function() {
    Route::get('taches', [TacheController::class,'index'])->name('projets.taches.index');
    Route::get('taches/create', [TacheController::class,'create'])->name('projets.taches.create');
    Route::post('taches', [TacheController::class,'store'])->name('projets.taches.store');
    Route::get('taches/{tache}/edit', [TacheController::class,'edit'])->name('projets.taches.edit');
    Route::put('taches/{tache}', [TacheController::class,'update'])->name('projets.taches.update');
    Route::delete('taches/{tache}', [TacheController::class,'destroy'])->name('projets.taches.destroy');
});

// Profil tasks
Route::prefix('profil')->middleware('auth')->group(function() {
    Route::get('tasks', [ProfilTaskController::class,'index'])->name('profil.tasks.index');
    Route::put('tasks/{tache}/update-status', [ProfilTaskController::class,'updateStatus'])->name('profil.tasks.update-status');
});

// ChefProjet
Route::prefix('chef')->name('chefprojets.')->middleware('auth')->group(function () {
    
    // Projects
    Route::get('/', [ChefProjetController::class, 'projectsIndex'])->name('index'); // was projectsIndex
    Route::get('/projects/create', [ChefProjetController::class, 'createProject'])->name('create_project');
    Route::post('/projects/store', [ChefProjetController::class, 'storeProject'])->name('store_project');
    Route::get('/projects/{projet}/edit', [ChefProjetController::class, 'editProject'])->name('edit_project');
    Route::put('/projects/{projet}', [ChefProjetController::class, 'updateProject'])->name('update_project');
    
    // Tasks
    Route::get('/projects/{projet}/tasks', [ChefProjetController::class, 'tasksIndex'])->name('tasks.index'); 
    Route::get('/projects/{projet}/tasks/create', [ChefProjetController::class, 'createTask'])->name('create_task');
    Route::post('/projects/{projet}/tasks/store', [ChefProjetController::class, 'storeTask'])->name('store_task');
    Route::get('/projects/{projet}/tasks/{tache}/edit', [ChefProjetController::class, 'editTask'])->name('edit_task');
    Route::put('/projects/{projet}/tasks/{tache}', [ChefProjetController::class, 'updateTask'])->name('update_task');
    Route::delete('/projects/{projet}/tasks/{tache}', [ChefProjetController::class, 'destroyTask'])->name('destroy_task');

});
Route::delete('/chefprojets/projects/{projet}', [ChefProjetController::class, 'destroyProject'])
    ->name('chefprojets.destroy_project');
Route::get('/projects/{projet}/tasks-only', [ChefProjetController::class, 'projectTasks'])
     ->name('chefprojets.tasks.project');
Route::get('/projets/{projet}/taches', [ProjetController::class, 'showTasks'])
    ->name('projets.taches.index');



