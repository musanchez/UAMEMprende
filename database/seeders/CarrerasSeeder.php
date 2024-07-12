<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carrera;

class CarrerasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carreras = [
            ['nombre' => 'Ingeniería en Sistemas'],
            ['nombre' => 'Medicina'],
            ['nombre' => 'Derecho'],
            ['nombre' => 'Administración de Empresas'],
            ['nombre' => 'Psicología'],
            ['nombre' => 'Arquitectura'],
            ['nombre' => 'Ingeniería Civil'],
            ['nombre' => 'Ingeniería Industrial'],
            ['nombre' => 'Diseño y Comunicación'],
            ['nombre' => 'Marketing'],
            ['nombre' => 'Odontología'],
            ['nombre' => 'Relaciones Internacionales'],
            ['nombre' => 'Negocios'],
            ['nombre' => 'Contabilidad']
            // Agrega aquí más nombres de carreras según sea necesario
        ];

        foreach ($carreras as $carrera) {
            Carrera::create($carrera);
        }
    }
}
