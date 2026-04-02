<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',          // Ajouté pour la gestion des rôles
        'service_id',    // Ajouté pour l'affectation aux services
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Le cast des attributs.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relation avec le Service.
     * Un utilisateur (Médecin/Secrétaire) appartient à un service.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Relation avec les Rendez-vous.
     * Un médecin a plusieurs rendez-vous.
     */
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class, 'user_id');
    }
}