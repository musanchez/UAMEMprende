<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmprendimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emprendimientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->string('imagen');
            
            // Definición de la clave foránea para 'categorias'
            $table->foreignId('categoria_id')->constrained('categorias');

            // Definición de la clave foránea para 'estudiantes' (emprendedores)
            $table->foreignId('emprendedor_id')->constrained('estudiantes');

            $table->timestamps();
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
            $table->dropForeign(['categoria_id']);
            $table->dropForeign(['emprendedor_id']);
        });

        Schema::dropIfExists('emprendimientos');
    }
}
