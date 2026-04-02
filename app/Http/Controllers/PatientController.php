<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RendezVous;
use App\Models\Creneau; // Ce modèle doit pointer vers la table 'disponibilites'


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Creneau;

class PatientController extends Controller
{
    // --- GESTION DES PATIENTS ---

    public function create()
    {
        if (auth()->user()->role !== 'secretaire') {
            abort(403, 'Action non autorisée.');
        }
        return view('secretaire.patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make('Sankara2026'),
            'role' => 'patient',
        ]);

        return redirect()->route('dashboard')->with('success', 'Le compte patient a été créé avec succès !');
    }

    // --- GESTION DES RENDEZ-VOUS ---

    public function createRendezVous()
    {
        $serviceId = auth()->user()->service_id;

        $medecins = User::where('role', 'medecin')
                        ->where('service_id', $serviceId) 
                        ->get();

        $patients = User::where('role', 'patient')->get();

        return view('secretaire.rendezvous.create', compact('medecins', 'patients'));
    }

    /**
     * RÉCUPÉRATION DES CRÉNEAUX (AJOURNÉ POUR TA BDD)
     */
    public function getDisponibilites(Request $request) {
        // Correction : On utilise 'user_id' et 'est_libre' = 1
        $creneaux = Creneau::where('user_id', $request->medecin_id)
            ->where('est_libre', 1) 
            ->where('date', '>=', now()->format('Y-m-d'))
            ->orderBy('date')
            ->orderBy('heure')
            ->get();

        return response()->json($creneaux->map(function($c) {
            return [
                'date_sql' => $c->date,
                'date_formatee' => \Carbon\Carbon::parse($c->date)->translatedFormat('d M'),
                'heure' => \Carbon\Carbon::parse($c->heure)->format('H:i')
            ];
        }));
    }

    public function storeRendezVous(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'medecin_id' => 'required|exists:users,id',
            'date'       => 'required|date|after_or_equal:today',
            'heure'      => 'required',
        ]);

        // 1. Vérifier si le médecin a déjà un RDV (sécurité double)
        $dejaPris = RendezVous::where('medecin_id', $request->medecin_id)
            ->where('date', $request->date)
            ->where('heure', $request->heure)
            ->whereIn('statut', ['confirme', 'en_attente'])
            ->exists();

        if ($dejaPris) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Désolé, ce médecin est déjà pris à cette heure-là.');
        }

        // 2. Création du Rendez-vous
        RendezVous::create([
            'patient_id' => $request->patient_id,
            'medecin_id' => $request->medecin_id,
            'date'       => $request->date,
            'heure'      => $request->heure,
            'statut'     => 'confirme',
            'motif'      => 'Consultation (Saisie par secrétariat)',
        ]);

        // 3. MISE À JOUR DE LA DISPONIBILITÉ
        // On passe 'est_libre' à 0 au lieu de changer un statut texte
        Creneau::where('user_id', $request->medecin_id)
            ->where('date', $request->date)
            ->where('heure', $request->heure)
            ->update(['est_libre' => 0]);

        return redirect()->route('dashboard')->with('success', 'Rendez-vous ajouté au planning.');
    }

    // --- REPROGRAMMATION ---

    public function reprogrammer(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'heure' => 'required',
        ]);

        $rdv = RendezVous::findOrFail($id);
        
        // Optionnel : Libérer l'ancien créneau avant de prendre le nouveau
        Creneau::where('user_id', $rdv->medecin_id)
            ->where('date', $rdv->date)
            ->where('heure', $rdv->heure)
            ->update(['est_libre' => 1]);

        $rdv->update([
            'date' => $request->date,
            'heure' => $request->heure,
            'statut' => 'en_attente'
        ]);

        // Marquer le nouveau créneau comme pris
        Creneau::where('user_id', $rdv->medecin_id)
            ->where('date', $request->date)
            ->where('heure', $request->heure)
            ->update(['est_libre' => 0]);

        return redirect()->back()->with('success', 'Le rendez-vous a été reprogrammé avec succès.');
    }

    // --- HISTORIQUE ---

    public function historique() 
    {
        $user = Auth::user();
        $serviceId = $user->service_id; 

        $historique = RendezVous::where('statut', '!=', 'en_attente')
            ->whereHas('medecin', function($q) use ($serviceId) {
                $q->where('service_id', $serviceId); 
            })
            ->with(['patient', 'medecin'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('secretaire.historique', compact('historique'));
    }
}