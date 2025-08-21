<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProfilTaskController;

// Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/home', function() {
    return view('welcome');
})->name('dashboard');

// Resources
Route::resource('projets', ProjetController::class);
Route::resource('profils', ProfilController::class);
Route::get('projets/{projet}/taches', [TacheController::class, 'projectTasks'])->name('projets.taches.index');

// Task routes under projects
Route::prefix('projets/{projet}')->group(function() {
    Route::get('taches', [TacheController::class, 'index'])->name('projets.taches.index');
    Route::get('taches/create', [TacheController::class, 'create'])->name('projets.taches.create');
    Route::post('taches', [TacheController::class, 'store'])->name('projets.taches.store');
    Route::get('taches/{tache}/edit', [TacheController::class, 'edit'])->name('projets.taches.edit');
    Route::put('taches/{tache}', [TacheController::class, 'update'])->name('projets.taches.update');
    Route::delete('taches/{tache}', [TacheController::class, 'destroy'])->name('projets.taches.destroy');
});

// individual Profile Tasks
Route::prefix('profil')->middleware('auth')->group(function() {
    Route::get('tasks', [ProfilTaskController::class, 'index'])->name('profil.tasks.index');
    Route::put('tasks/{tache}/update-status', [ProfilTaskController::class, 'updateStatus'])->name('profil.tasks.update-status');
});