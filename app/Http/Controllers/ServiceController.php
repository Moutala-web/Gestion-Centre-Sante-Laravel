<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service; // On ajoute l'import ici

class ServiceController extends Controller
{
    public function index()
    {
        // Plus besoin de mettre \App\Models\ car on l'a importé en haut
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    // Correction ici : on utilise juste Request $request
    public function store(Request $request)
{
    // 1. Validation du nom du service
    $request->validate([
        'nom' => 'required|string|max:255|unique:services',
    ]);

    // 2. Création dans la base de données
    Service::create([
        'nom' => $request->nom,
    ]);

    // 3. Retour à la page avec un message de succès
    return redirect()->route('admin.services.index')->with('success', 'Service ajouté avec succès !');
}
}