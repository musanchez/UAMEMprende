<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadoEmpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estados_emps', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        // Inserta los estados por defecto
        DB::table('estados_emps')->insert([
            ['nombre' => 'PENDIENTE'],
            ['nombre' => 'VERIFICADO'],
            ['nombre' => 'RECHAZADO'],
            ['nombre' => 'RESTRINGIDO'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estados_emps');
    }
}
