<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use App\Models\RendezVous;
use Illuminate\Support\Facades\Hash;

class HospitalTestSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer un patient de test
        $patient = Patient::create([
            'nom_complet' => 'Jean Dupont',
            'telephone' => '70000000',
            'date_naissance' => '1990-05-15',
            'genre' => 'M',
            'antecedents' => 'Allergie à la pénicilline'
        ]);

        // 2. Récupérer le médecin que tu viens de créer (ou en créer un)
        $medecin = User::where('role', 'medecin')->first();

        if ($medecin) {
            // 3. Créer un rendez-vous pour AUJOURD'HUI
            RendezVous::create([
                'user_id' => $medecin->id,
                'patient_id' => $patient->id,
                'date' => now()->format('Y-m-d'),
                'heure' => '10:30',
                'motif' => 'Consultation de suivi',
                'statut' => 'en_attente'
            ]);
        }
    }
}