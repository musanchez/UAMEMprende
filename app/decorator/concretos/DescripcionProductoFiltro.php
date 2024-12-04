<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Collection;

class DescripcionProductoFiltro extends BaseProductoFiltro
{
    protected function applyFilter(Collection $productos, $query)
    {
        return $productos->filter(function ($producto) use ($query) {
            return stripos($producto->descripcion, $query) !== false;
        });
    }
}
