<?php

use App\Http\Livewire\AutoGenerateService;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;


use App\Http\Controllers\TableauServiceController;
use App\Http\Controllers\TableauDeServiceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::resource('users', UserController::class);
Route::resource('postes', PosteController::class);
/*Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
*/
//Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');



// Routes pour le gestionnaire de tableau de service
Route::resource('/tableaux_de_service', TableauDeServiceController::class);


//nouveau
Route::resource('tableau_service', TableauServiceController::class);



/*
//service route
use App\Http\Controllers\DashboardController;

Route::get('/services', [ServiceController::class, 'index'])->name('services.index'); // Liste des services
Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create'); // Formulaire d'ajout
Route::post('/services', [ServiceController::class, 'store'])->name('services.store'); // Enregistrement d'un service
Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit'); // Formulaire de modification
Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update'); // Mise à jour d'un service
Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy'); // Suppression d'un service

*/




use App\Livewire\ServiceTable;
use App\Livewire\ServiceCreate;
use App\Livewire\ServiceEdit;

// Affichage du tableau de service (GET)
Route::get('/services', ServiceTable::class)->name('services.index');

// Création d'un service (GET pour afficher le formulaire)
Route::get('/services/create', ServiceCreate::class)->name('services.create');

// Modification d'un service (GET pour afficher le formulaire d'édition)
Route::get('/services/{serviceId}/edit', ServiceEdit::class)->name('services.edit');

// Ajout d'un service (POST)
Route::post('/services', [ServiceController::class, 'store'])->name('services.store');

// Suppression d'un service (DELETE)
Route::delete('/services/{serviceId}', [ServiceController::class, 'destroy'])->name('services.destroy');


Route::get('/auto-generate-service', AutoGenerateService::class)->name('auto-generate-service');


use App\Http\Controllers\MailController;
Route::get('/mail/{id_tableauService}', [MailController::class, 'send'])->name('mail');
