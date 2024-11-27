<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Collection;

abstract class BaseProductoFiltro
{
    protected $nextFiltro;

    public function __construct(BaseProductoFiltro $nextFiltro = null)
    {
        $this->nextFiltro = $nextFiltro;
    }

    public function apply(Collection $productos, $query)
    {
        $filtered = $this->applyFilter($productos, $query);

        if ($this->nextFiltro) {
            return $this->nextFiltro->apply($filtered, $query);
        }

        return $filtered;
    }

    abstract protected function applyFilter(Collection $productos, $query);
}
