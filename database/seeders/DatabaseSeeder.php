<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@inventario.test'],
            [
                'name' => 'Administrador',
                'password' => 'password123',
                'role' => 'administrador',
            ]
        );

        User::updateOrCreate(
            ['email' => 'vendedor@inventario.test'],
            [
                'name' => 'Vendedor',
                'password' => 'password123',
                'role' => 'vendedor',
            ]
        );
    }
}