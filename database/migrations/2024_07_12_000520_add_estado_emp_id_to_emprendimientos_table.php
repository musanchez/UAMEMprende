<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoEmpIdToEmprendimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emprendimientos', function (Blueprint $table) {
            $table->foreignId('estado_emp_id')->default(1)->constrained('estados_emps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emprendimientos', function (Blueprint $table) {
            $table->dropForeign(['estado_emp_id']);
            $table->dropColumn('estado_emp_id');
        });
    }
}
