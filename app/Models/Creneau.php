<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Creneau extends Model
{
    use HasFactory;

    // TRÈS IMPORTANT : Ta table s'appelle 'disponibilites' en minuscule
    protected $table = 'disponibilites';

    // On autorise le remplissage des colonnes réelles de ta base
    protected $fillable = [
        'user_id',   // L'ID du médecin
        'date',
        'heure',
        'est_libre', // 1 pour libre, 0 pour réservé
    ];

    public function medecin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}