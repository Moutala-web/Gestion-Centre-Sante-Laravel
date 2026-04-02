<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RendezVous; 
use App\Models\User;
use App\Models\Disponibilite;

class DashboardController extends Controller
{
    /**
     * Redirige l'utilisateur vers son dashboard selon son rôle avec les données nécessaires.
     */
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // --- DASHBOARD ADMIN ---
        if ($role === 'admin') {
            $stats = [
                'medecins' => User::where('role', 'medecin')->count(),
                'secretaires' => User::where('role', 'secretaire')->count(),
                'patients' => User::where('role', 'patient')->count(),
            ];
            return view('admin.dashboard', compact('stats'));
        } 
        
        // --- DASHBOARD MÉDECIN ---
        if ($role === 'medecin') {
            $rendezVous = RendezVous::where('medecin_id', $user->id)
                                ->where('statut', 'confirme')
                                ->whereDate('date', now())
                                ->with('patient')
                                ->orderBy('heure')
                                ->get();

            $mesDispos = Disponibilite::where('user_id', $user->id)
                                ->where('date', '>=', now()->toDateString())
                                ->orderBy('date')
                                ->get();

            return view('medecin.dashboard', compact('user', 'rendezVous', 'mesDispos'));
        } 
        
        // --- DASHBOARD SECRÉTAIRE ---
        if ($role === 'secretaire') {
            // 1. Les demandes en attente (à traiter)
            $demandes = RendezVous::where('statut', 'en_attente')
                ->whereHas('medecin', function($query) use ($user) {
                    $query->where('service_id', $user->service_id);
                })
                ->with(['patient', 'medecin'])
                ->get();

            // 2. L'historique des actions (déjà confirmés ou annulés)
            $historique = RendezVous::whereIn('statut', ['confirme', 'annule'])
                ->whereHas('medecin', function($query) use ($user) {
                    $query->where('service_id', $user->service_id);
                })
                ->with(['patient', 'medecin'])
                ->orderBy('updated_at', 'desc') // On met les plus récents en premier
                ->take(10) // On limite aux 10 derniers pour ne pas encombrer la page
                ->get();

            return view('secretaire.dashboard', compact('demandes', 'historique'));
        }

        // --- DASHBOARD PATIENT (Par défaut) ---
        $medecins = User::where('role', 'medecin')->get();

        $disponibilites = Disponibilite::where('est_libre', true)
                            ->where('date', '>=', now()->toDateString())
                            ->orderBy('date')
                            ->orderBy('heure')
                            ->get();

        $mesRendezVous = RendezVous::where('patient_id', $user->id)
                            ->with('medecin')
                            ->orderBy('date', 'desc')
                            ->get();

        return view('patient.dashboard', compact('user', 'medecins', 'disponibilites', 'mesRendezVous'));
    }
}