<?php

namespace App\decorator\concretos;

use App\decorator\EmprendimientoFiltro;
use App\decorator\EmprendimientoFiltroDecorador;


class NombreFiltro extends EmprendimientoFiltroDecorador
{
    protected $nombre;

    public function __construct(EmprendimientoFiltro $filter, $nombre)
    {
        parent::__construct($filter);
        $this->nombre = $nombre;
    }

    public function filter($emprendimientos)
    {
        $emprendimientos = parent::filter($emprendimientos);

        return $emprendimientos->where('nombre', 'like', '%' . $this->nombre . '%');
    }
}
