<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CarrerasSeeder::class);
        $this->call(EstudiantesSeeder::class); // Agrega la llamada al seeder de estudiantes
        $this->call(EstadoEmpSeeder::class); // Agregar esta línea para sembrar EstadoEmp
        $this->call(CategoriaSeeder::class);
    }
}
