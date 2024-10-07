<?php

namespace App\decorator; // Asegúrate que este es el directorio correcto

use App\decorator\EmprendimientoFiltro;

class BaseEmprendimientoFiltro implements EmprendimientoFiltro
{
    public function filter($emprendimientos)
    {
        return $emprendimientos;
    }
}
