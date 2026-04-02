<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Création du Médecin
    \App\Models\User::create([
        'name' => 'Dr. Sawadogo',
        'email' => 'medecin@test.com',
        'password' => bcrypt('password'),
        'role' => 'medecin',
    ]);

    // Création d'un Patient
    \App\Models\User::create([
        'name' => 'Jean Dupont',
        'email' => 'patient@test.com',
        'password' => bcrypt('password'),
        'role' => 'patient',
    ]);
}
}
