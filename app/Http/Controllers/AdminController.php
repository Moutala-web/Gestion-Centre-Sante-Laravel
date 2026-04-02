<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service; // Assure-toi d'avoir un modèle Service

class AdminController extends Controller
{
    // Affiche la page des affectations
    public function affectations()
    {
        $users = User::whereIn('role', ['medecin', 'secretaire'])->get();
        $services = Service::all();
        
        return view('admin.affectations.index', compact('users', 'services'));
    }

    // Enregistre le changement de service
    public function updateAffectation(Request $request, User $user)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $user->update(['service_id' => $request->service_id]);

        return back()->with('success', 'Affectation mise à jour avec succès !');
    }
}