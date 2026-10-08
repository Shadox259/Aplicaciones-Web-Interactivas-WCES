<?php

namespace Database\Seeders;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Admin Demo',
            'email'    => 'admin@demo.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Jugador Demo',
            'email'    => 'jugador@demo.com',
            'password' => Hash::make('password'),
            'role'     => 'jugador',
        ]);

        Tournament::create([
            'user_id'    => $admin->id,
            'nombre'     => 'Copa Fútbol Primavera',
            'juego'      => 'Fútbol',
            'fecha'      => now()->addDays(10)->toDateString(),
            'cupo'       => 16,
            'descripcion'=> 'Torneo relámpago 5v5.',
            'abierto'    => true,
        ]);

        Tournament::create([
            'user_id'    => $admin->id,
            'nombre'     => 'Torneo Smash Bros',
            'juego'      => 'Videojuegos',
            'fecha'      => now()->addDays(20)->toDateString(),
            'cupo'       => 8,
            'descripcion'=> '1v1 sin items.',
            'abierto'    => true,
        ]);
    }
}