<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disponibilite extends Model
{
    use HasFactory;

    // Ajoute ces lignes pour autoriser l'enregistrement de ces colonnes
    protected $fillable = [
        'user_id',
        'date',
        'heure',
        'est_libre',
    ];

    // Relation avec l'utilisateur (le médecin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}