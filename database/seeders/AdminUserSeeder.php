<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Verifica se já existe um administrador para evitar duplicatas
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('@Pa5MT12'),
                'role' => 'admin',
                'cargo' => 'Administrador',
                'matricula' => 'ADM001', // Campo obrigatório
                'profile_img' => 'default.png', // Campo com valor padrão
            ]);
        }
    }
}
