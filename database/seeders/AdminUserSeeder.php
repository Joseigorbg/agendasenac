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
                'email' => 'admin@ceo43.com',
                'password' => bcrypt('@Pa5MT12'), // Senha criptografada
                'role' => 'admin', // Definir como administrador
                'cargo' => 'Administrador', // Cargo obrigatório
                'matricula' => 'ADM001', // Campo de matrícula único e obrigatório
                'profile_img' => 'default.png', // Imagem padrão
            ]);
        }
    }
}
