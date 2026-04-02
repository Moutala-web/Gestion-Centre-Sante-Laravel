<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordonnance extends Model
{
    use HasFactory;

    protected $fillable = [
        'rendez_vous_id',
        'patient_id',
        'medecin_id',
        'contenu',
        'date_prescription',
    ];

    // Relation avec le rendez-vous
    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class);
    }

    // Relation avec le patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}