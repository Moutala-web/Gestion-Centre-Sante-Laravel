<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    /**
     * Nom de la table associée (optionnel si le nom est au pluriel en anglais)
     */
    protected $table = 'rendez_vous';

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'medecin_id',      // L'ID du médecin
        'patient_id',
        'disponibilite_id ',  
        'date',
        'heure',
        'motif',
        'statut',
    ];

    /**
     * Relation avec le Médecin (User).
     * Un rendez-vous appartient à un médecin.
     */
    public function medecin()
{
    // Remplace 'user_id' par 'medecin_id'
    return $this->belongsTo(User::class, 'medecin_id');
}

    /**
     * Relation avec le Patient.
     * Un rendez-vous appartient à un patient.
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}