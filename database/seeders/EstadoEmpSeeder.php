<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\EstadoEmp;

class EstadoEmpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = [
            ['nombre' => 'PENDIENTE'],
            ['nombre' => 'VERIFICADO'],
            ['nombre' => 'RECHAZADO'],
        ];

        // Insertar los estados en la tabla estado_emps
        DB::table('estados_emps')->insert($estados);
    }
}
