<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\utilisateur;
use Illuminate\Support\Facades\Hash;

class UtilisateurSeeder extends Seeder
{
    public function run(): void
    {
        utilisateur::create([
            'nom' => 'test',
            'prenom' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('123456'),
            'type' => 'admin',
        ]);
    }
}
