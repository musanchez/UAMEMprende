<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Collection;

class NombreProductoFiltro extends BaseProductoFiltro
{
    protected function applyFilter(Collection $productos, $query)
    {
        return $productos->filter(function ($producto) use ($query) {
            return stripos($producto->nombre, $query) !== false;
        });
    }
}
