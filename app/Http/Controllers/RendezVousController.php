<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RendezVous; 
use App\Models\Disponibilite;
use Illuminate\Support\Facades\Auth;
use App\Notifications\RendezVousNotification;
class RendezVousController extends Controller
{
    /**
     * Enregistrer la demande de rendez-vous du patient via un créneau.
     */
    public function store(Request $request)
    {
        $request->validate([
            'disponibilite_id' => 'required|exists:disponibilites,id',
            'motif' => 'required|string|max:255',
        ]);

        $dispo = Disponibilite::findOrFail($request->disponibilite_id);

        if (!$dispo->est_libre) {
            return back()->with('error', 'Ce créneau vient juste d\'être réservé.');
        }

        RendezVous::create([
            'patient_id'       => Auth::id(), 
            'medecin_id'       => $dispo->user_id,
            'disponibilite_id' => $dispo->id, // Important pour l'annulation future
            'date'             => $dispo->date,
            'heure'            => $dispo->heure,
            'motif'            => $request->motif,
            'statut'           => 'en_attente' 
        ]);

        $dispo->update(['est_libre' => false]);

        return back()->with('success', 'Votre demande est en cours de validation par la secrétaire.');
    }

    /**
     * Action pour la SECRÉTAIRE : Confirmer
     */
    public function confirmer($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => 'confirme']);
        $rdv->user->notify(new RendezVousNotification('confirmé', 'Votre rendez-vous a été validé par le médecin.'));

        return back()->with('success', 'Rendez-vous confirmé avec succès !');
    }

    /**
     * Action pour la SECRÉTAIRE : Refuser (et libérer le créneau)
     */
    public function refuser($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => 'annule']);
        $rdv->user->notify(new RendezVousNotification('annulé', 'Désolé, ce créneau n\'est plus disponible.'));

        // On libère le créneau associé pour qu'un autre patient puisse le prendre
        if ($rdv->disponibilite_id) {
            Disponibilite::where('id', $rdv->disponibilite_id)->update(['est_libre' => true]);
        }

        return back()->with('error', 'Le rendez-vous a été décliné et le créneau libéré.');
    }

    /**
     * Permettre au patient d'annuler sa propre demande.
     */
    public function destroy(RendezVous $rendezVous)
    {
        if ($rendezVous->patient_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        if ($rendezVous->statut !== 'en_attente') {
            return back()->with('error', 'Impossible d\'annuler un rendez-vous déjà traité.');
        }

        if ($rendezVous->disponibilite_id) {
            Disponibilite::where('id', $rendezVous->disponibilite_id)->update(['est_libre' => true]);
        }

        $rendezVous->delete();

        return back()->with('success', 'Rendez-vous annulé avec succès !');
    }
}