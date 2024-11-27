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
        Estudiante::firstOrCreate(
            ['cif'=> '00001111'],[
            'nombre' => 'Nancy',
            'apellido' => 'Santeliz',
            'celular' => '868679123', // Ejemplo de celular
            'email' => 'nsanteliz@uamv.edu.ni',
            'cif' => '00001111',
            'password' => Hash::make('123123123'), // Cifra la contraseña 'password'
            'admin' => '1',
            'carrera_id' => null
            // No es necesario incluir 'admin' ya que es false por defecto en el factory
        ]);

        Estudiante::firstOrCreate(
            ['cif'=> '21010348'],[
            'nombre' => 'Marcos',
            'apellido' => 'Sanchez',
            'celular' => '78550671', // Ejemplo de celular
            'email' => 'musanchez@uamv.edu.ni',
            'cif' => '21010348',
            'password' => Hash::make('12345678'), // Cifra la contraseña 'password'
            'carrera_id' => 1
            // No es necesario incluir 'admin' ya que es false por defecto en el factory
        ]);

        Estudiante::firstOrCreate(
            ['cif'=> '19014795'],[
            'nombre' => 'Gabriel',
            'apellido' => 'Chang',
            'celular' => '76291824', // Ejemplo de celular
            'email' => 'gdchang@uamv.edu.ni',
            'cif' => '19014795',
            'password' => Hash::make('12345678'), // Cifra la contraseña 'password'
            'carrera_id' => 1
            // No es necesario incluir 'admin' ya que es false por defecto en el factory
        ]);

        Estudiante::firstOrCreate(
            ['cif'=> '19014581'],[
            'nombre' => 'Carlos',
            'apellido' => 'Toruño',
            'celular' => '88807744', // Ejemplo de celular
            'email' => 'cdtoruno@uamv.edu.ni',
            'cif' => '19014581',
            'password' => Hash::make('12345678'), // Cifra la contraseña 'password'
            'carrera_id' => 1
            // No es necesario incluir 'admin' ya que es false por defecto en el factory
        ]);

        Estudiante::firstOrCreate(
            ['cif'=> '19015127'],[
            'nombre' => 'Lester',
            'apellido' => 'Rodriguez',
            'celular' => '82896538', // Ejemplo de celular
            'email' => 'larodriguezc@uamv.edu.ni',
            'cif' => '19015127',
            'password' => Hash::make('12345678'), // Cifra la contraseña 'password'
            'carrera_id' => 1
            // No es necesario incluir 'admin' ya que es false por defecto en el factory
        ]);

        Estudiante::factory()->count(50)->create([
            'admin' => 0, // Asegurarse de que todos los estudiantes generados no sean administradores
        ])->each(function ($estudiante) {
            // Asignar un `carrera_id` aleatorio entre 1 y 14
            $estudiante->carrera_id = rand(1, 14);
            $estudiante->save();
        });
    }
}
