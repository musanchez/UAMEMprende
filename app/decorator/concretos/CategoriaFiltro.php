<?php

namespace App\decorator\concretos;

use App\decorator\EmprendimientoFiltro;
use App\decorator\EmprendimientoFiltroDecorador;


class CategoriaFiltro extends EmprendimientoFiltroDecorador
{
    protected $categoria;

    public function __construct(EmprendimientoFiltro $filter, $categoria)
    {
        parent::__construct($filter);
        $this->categoria = $categoria;
    }

    public function filter($emprendimientos)
    {
        $emprendimientos = parent::filter($emprendimientos);

        return $emprendimientos->where('categoria_id', $this->categoria);
    }
}
