<?php

namespace App\Http\Controllers;
use App\Models\Ordonnance;

use Illuminate\Http\Request;
use App\Models\Creneau; // Assure-toi que le modèle s'appelle Creneau ou Disponibilite selon ton fichier Models
use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MedecinController extends Controller
{
    /**
     * Enregistre un nouveau créneau dans la table 'disponibilites'
     */
    public function storeDisponibilite(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'heure' => 'required',
        ]);

        // Utilise le modèle Creneau (qui pointe vers la table 'disponibilites')
        Creneau::create([
            'user_id' => Auth::id(), // ID du médecin connecté
            'date' => $request->date,
            'heure' => $request->heure,
            'est_libre' => true, // Par défaut le créneau est libre
        ]);

        return redirect()->back()->with('success', 'Créneau ouvert avec succès !');
    }

    /**
     * Affiche la page de recherche de patient (Route: medecin.recherche_patient)
     */
    public function recherchePatient(Request $request)
    {
        $query = $request->input('search');
        
        // Si une recherche est lancée, on cherche dans les utilisateurs ayant le rôle 'patient'
        $patients = null;
        if ($query) {
            $patients = User::where('role', 'patient')
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('telephone', 'LIKE', "%{$query}%");
                })->get();
        }

        return view('medecin.recherche', compact('patients'));
    }

    /**
     * Affiche l'historique médical / dossiers (Route: medecin.dossiers)
     */
    public function listeDossiers()
    {
        // Récupère les rendez-vous passés du médecin connecté pour voir l'historique
        $dossiers = RendezVous::where('medecin_id', Auth::id())
            ->with('patient')
            ->orderBy('date', 'desc')
            ->get();

        return view('medecin.dossiers', compact('dossiers'));
    }

    /**
     * Action pour le bouton 'Consulter' du Dashboard
     */
    public function consulter($id)
    {
        $rdv = RendezVous::with('patient')->findOrFail($id);
        return view('medecin.consultation', compact('rdv'));
    }
    public function cloturer($id)
{
    $rdv = RendezVous::findOrFail($id);
    $rdv->update(['statut' => 'termine']);

    return redirect()->route('dashboard')->with('success', 'La consultation est terminée.');
}
public function createOrdonnance($id)
{
    $rdv = RendezVous::with('patient')->findOrFail($id);
    
    // Cette ligne cherchera le fichier resources/views/medecin/ordonnance.blade.php
    return view('medecin.ordonnance', compact('rdv'));
}
public function storeOrdonnance(Request $request, $id)
{
    $request->validate([
        'contenu' => 'required|min:10',
    ]);

    $rdv = RendezVous::findOrFail($id);

    Ordonnance::create([
        'rendez_vous_id' => $rdv->id,
        'patient_id'     => $rdv->patient_id,
        'medecin_id'     => auth()->id(),
        'contenu'        => $request->contenu,
        'date_prescription' => now(),
    ]);

    // Redirection vers la page de consultation avec un message
    return redirect()->route('medecin.consulter', $id)
                     ->with('success', 'L’ordonnance a été enregistrée avec succès !');
}
}