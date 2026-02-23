<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Responsable;
use Illuminate\Support\Str;

class UserResponsableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $responsables = Responsable::whereNull('user_id')->get();
        
        foreach ($responsables as $responsable) {
            // Crear usuario para cada responsable
            $user = User::create([
                'name' => $responsable->nombre_completo,
                'email' => strtolower(str_replace(' ', '.', $responsable->nombre)) . '.' . strtolower(str_replace(' ', '.', $responsable->apellido)) . '@hcd.gov',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'), // Contraseña temporal
                'remember_token' => Str::random(10),
            ]);
            
            // Asociar el usuario con el responsable
            $responsable->update(['user_id' => $user->id]);
            
            $this->command->info("Usuario creado para {$responsable->nombre_completo}: {$user->email}");
        }
        
        $this->command->info('Se han creado usuarios para todos los responsables.');
    }
}
