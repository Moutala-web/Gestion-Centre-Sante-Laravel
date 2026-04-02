<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Création des Services (selon ton rapport)
        $cardio = Service::create([
            'nom' => 'Cardiologie',
            'description' => 'Service spécialisé dans les maladies du cœur'
        ]);

        $pedia = Service::create([
            'nom' => 'Pédiatrie',
            'description' => 'Service de soins pour enfants'
        ]);

        $general = Service::create([
            'nom' => 'Médecine Générale',
            'description' => 'Consultations générales'
        ]);

        // 2. Création de ton compte Administrateur
        User::create([
            'name' => 'Admin UTS',
            'email' => 'admin@uts.bf',
            'password' => Hash::make('password'), // Ton mot de passe sera 'password'
            'role' => 'admin',
        ]);

        // 3. Création d'un compte Médecin pour test
        User::create([
            'name' => 'Dr Sawadogo',
            'email' => 'sawadogo@uts.bf',
            'password' => Hash::make('password'),
            'role' => 'medecin',
            'service_id' => $cardio->id, // Lié à la Cardiologie
        ]);
        // 4. Création d'un compte Patient pour test
        User::create([
            'name' => 'Moutala Sawadogo',
            'email' => 'patient@uts.bf',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);
        

        echo "Données insérées avec succès !";
    }
}