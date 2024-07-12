<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Hash;

class EstudiantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estudiante::factory()->create([
            'nombre' => 'Nancy',
            'apellido' => 'Santeliz',
            'celular' => '868679123', // Ejemplo de celular
            'email' => 'nsanteliz@uamv.edu.ni',
            'cif' => '00001111',
            'password' => Hash::make('123123123'), // Cifra la contraseña 'password'
            'admin' => '1'
            // No es necesario incluir 'admin' ya que es false por defecto en el factory
        ]);

        Estudiante::factory()->create([
            'nombre' => 'Gabriel',
            'apellido' => 'Chang',
            'celular' => '76291888', // Ejemplo de celular
            'email' => 'gdchang@uamv.edu.ni',
            'cif' => '19014795',
            'password' => Hash::make('123123123'), // Cifra la contraseña 'password'
            'carrera_id' => 1,
            // No es necesario incluir 'admin' ya que es false por defecto en el factory
        ]);
    }
}
