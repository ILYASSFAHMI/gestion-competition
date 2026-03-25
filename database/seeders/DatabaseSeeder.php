<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer l'administrateur principal (Ilyass)
        User::create([
            'name'     => 'Ilyass Administrateur',
            'email'    => 'ilyass.fcb98@gmail.com',
            'password' => Hash::make('ilyass1234'),
            'role'     => 'admin',
        ]);
        
        // La base de données est vide par défaut, vous pouvez ajouter vos données manuellement depuis l'interface admin.
    }
}
