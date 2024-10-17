<?php

namespace Database\Seeders;

use App\Models\Carrera;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cargar los permisos existentes y sus roles
        $this->call(ShieldSeeder::class);

        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);
        // Asignar el rol de super admin al usuario admin
        $user->assignRole('super_admin');

        // Crear 10 usuarios de prueba de tipo oficina
        User::factory()->count(10)->create([
            'tipo' => User::OFICINAS,
        ])->each(function ($user) {
            $user->assignRole('oficina');
        });

        // Crear 10 usuarios de prueba de tipo profesor
        User::factory()->count(10)->create([
            'tipo' => User::DOCENTES,
        ])->each(function ($user) {
            $user->assignRole('profesor');
        });

        //Crear carreras de prueba
        $carreras = [
            ['codigo' => 3401, 'nombre' => 'Técnico Superior en Educación Física, Deportes y Recreación'],
            ['codigo' => 3122, 'nombre' => 'Ciencias de la Educación con Mención en Sociales'],
            ['codigo' => 3123, 'nombre' => 'Ciencias de la Educación con Mención en Ciencias Naturales'],
            ['codigo' => 3120, 'nombre' => 'Ciencias de la Educación con Mención en Español'],
            ['codigo' => 3101, 'nombre' => 'Pedagogía'],
            ['codigo' => 1101, 'nombre' => 'Teología'],
            ['codigo' => 3301, 'nombre' => 'Inglés'],
            ['codigo' => 7104, 'nombre' => 'Psicología Clínica'],
            ['codigo' => 4101, 'nombre' => 'Derecho'],
            ['codigo' => 5101, 'nombre' => 'Administración de Empresas'],
            ['codigo' => 5201, 'nombre' => 'Contaduría Pública y Auditoría'],
            ['codigo' => 5301, 'nombre' => 'Banca y Finanzas'],
            ['codigo' => 2102, 'nombre' => 'Ingeniería de Sistemas'],
            ['codigo' => 8101, 'nombre' => 'Ingeniería en Gerencia Agropecuaria'],
            ['codigo' => 7101, 'nombre' => 'Técnico Superior en Enfermería General'],
            ['codigo' => 7201, 'nombre' => 'Farmacia'],
            ['codigo' => 7102, 'nombre' => 'Enfermería'],
        ];

        foreach ($carreras as $index => $carrera) {
            Carrera::create([
                'duracion' => 5,
                'nombre' => $carrera['nombre'],
            ]);
        }
    }
}
