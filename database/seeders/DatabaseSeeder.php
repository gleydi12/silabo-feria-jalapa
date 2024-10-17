<?php


namespace Database\Seeders;


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
           $user->assignRole('docente');
       });
   }
}
