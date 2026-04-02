<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminController;
Route::get('/', function () {
    return view('welcome');
});

// Route unique du Dashboard (Redirection selon rôle)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ACTIONS DU MÉDECIN ---
    Route::get('/recherche-patient', [MedecinController::class, 'recherchePatient'])->name('medecin.recherche_patient');
    Route::get('/dossiers-medicaux', [MedecinController::class, 'listeDossiers'])->name('medecin.dossiers');
    Route::get('/rendezvous/{id}/consulter', [MedecinController::class, 'consulter'])->name('medecin.consulter');
    Route::get('/rendezvous/{id}/ordonnance', [MedecinController::class, 'createOrdonnance'])->name('medecin.ordonnance.create');
    Route::post('/rendezvous/{id}/ordonnance', [MedecinController::class, 'storeOrdonnance'])->name('medecin.ordonnance.store');
    
    // NOUVELLE ROUTE : Pour le bouton "TERMINER LA SÉANCE"
    Route::patch('/rendezvous/{id}/cloturer', [MedecinController::class, 'cloturer'])->name('medecin.cloturer');
    
    // NOUVELLE ROUTE : Pour le bouton "AJOUTER UNE ORDONNANCE" (À adapter selon ton controller)
    Route::get('/rendezvous/{id}/ordonnance', [MedecinController::class, 'createOrdonnance'])->name('medecin.ordonnance.create');

    // --- GESTION DES DISPONIBILITÉS ---
    Route::post('/disponibilites', [MedecinController::class, 'storeDisponibilite'])->name('medecin.disponibilite.store');
    
    // --- ACTIONS SUR LES RDV ---
    Route::delete('/rendezvous/{rendezVous}', [RendezVousController::class, 'destroy'])->name('rendezvous.destroy');
    Route::patch('/rendezvous/{id}/confirmer', [RendezVousController::class, 'confirmer'])->name('rendezvous.confirmer');
    Route::patch('/rendezvous/{id}/refuser', [RendezVousController::class, 'refuser'])->name('rendezvous.refuser');

    // --- REPROGRAMMATION & SECRÉTARIAT ---
    Route::patch('/rendezvous/{id}/reprogrammer', [PatientController::class, 'reprogrammer'])->name('rendezvous.reprogrammer');
    Route::get('/historique', [PatientController::class, 'historique'])->name('historique.index');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/api/medecin/{id}/occupations', [PatientController::class, 'getOccupations']);
    Route::get('/rendezvous/create', [PatientController::class, 'createRendezVous'])->name('rendezvous.create');
    Route::post('/rendezvous/store-manuel', [PatientController::class, 'storeRendezVous'])->name('rendezvous.store_manuel');
    Route::get('/api/get-creneaux-ouverts', [PatientController::class, 'getDisponibilites']);

    // Réservation côté Patient
    Route::post('/rendezvous/reserver', [RendezVousController::class, 'store'])->name('rendezvous.store');

    // --- ADMIN ---
   
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/affectations', [AdminController::class, 'affectations'])->name('affectations.index');
        Route::patch('/affectations/{user}', [AdminController::class, 'updateAffectation'])->name('affectations.update');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });
});

require __DIR__.'/auth.php';