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
        $nombresExistentes = Producto::where('emprendimiento_id', $this->emprendimientoId)
            ->pluck('nombre')
            ->map(fn($nombre) => strtolower(trim($nombre)))
            ->toArray();

        $nombresEnArchivo = [];
        $errores = [];

        foreach ($rows as $index => $row) {
            // Saltar la fila de encabezado
            if ($index === 0) continue;

            // Verificar si la fila está vacía o si el nombre no está definido
            if (!isset($row[0]) || trim($row[0]) === '') {
                continue; // Ignorar filas vacías
            }

            $nombre = strtolower(trim($row[0]));

            // Verificar duplicados en la BD
            if (in_array($nombre, $nombresExistentes)) {
                $errores[] = "El producto '{$row[0]}' ya existe en la base de datos.";
            }

            // Verificar duplicados en el archivo
            if (in_array($nombre, $nombresEnArchivo)) {
                $errores[] = "El producto '{$row[0]}' está duplicado en el archivo.";
            } else {
                $nombresEnArchivo[] = $nombre;
            }
        }

        // Si hay errores, lanzar una excepción
        if (!empty($errores)) {
            throw new \Exception(implode(' | ', $errores));
        }

        // Crear productos si no hay errores
        foreach ($rows as $index => $row) {
            if ($index === 0) continue;

            if (!isset($row[0]) || trim($row[0]) === '') {
                continue; // Ignorar filas vacías
            }

            Producto::create([
                'nombre' => $row[0],
                'descripcion' => $row[1] ?? null,
                'precio' => $row[2] ?? 0,
                'emprendimiento_id' => $this->emprendimientoId,
                'imagen' => 'productos/logo.png',
            ]);
        }
    }
}

