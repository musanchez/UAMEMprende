<?php
namespace App\Imports;

use App\Models\Producto;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductosImport implements ToCollection
{
    private $emprendimientoId;

    public function __construct($emprendimientoId)
    {
        $this->emprendimientoId = $emprendimientoId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Salta la fila de encabezados
            if ($index === 0) continue;

            Producto::create([
                'nombre' => $row[0],
                'descripcion' => $row[1],
                'precio' => $row[2],
                'emprendimiento_id' => $this->emprendimientoId,
                'imagen' => 'logo.png',
            ]);
        }
    }
}

