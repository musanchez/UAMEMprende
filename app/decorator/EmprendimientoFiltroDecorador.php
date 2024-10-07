<?php

namespace App\decorator;

use App\decorator\EmprendimientoFiltro;

abstract class EmprendimientoFiltroDecorador implements EmprendimientoFiltro
{
    protected $filter;

    public function __construct(EmprendimientoFiltro $filter)
    {
        $this->filter = $filter;
    }

    public function filter($emprendimientos)
    {
        return $this->filter->filter($emprendimientos);
    }
}
