<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'nom_complet',
        'telephone',
        'date_naissance',
        'genre',
        'antecedents',
    ];

    /**
     * Relation avec les Rendez-vous.
     * Un patient peut avoir plusieurs rendez-vous au centre de santé.
     */
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }
}