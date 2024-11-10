<?php

namespace App\Exports;

use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class EstudianteExport implements FromQuery, WithHeadings, WithStyles, WithMapping, WithEvents
{
    /**
     * Consulta de estudiantes para exportación.
     *
     * @return Builder
     */
    public function query()
    {
        return Estudiante::query()
            ->with('carrera')
            ->select('cif', 'nombre', 'apellido', 'carrera_id', 'email', 'status')
            ->where('admin', false);
    }

    /**
     * Encabezados de la hoja Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'CIF',
            'Nombre Completo',
            'Carrera',
            'Correo',
            'Estatus',
        ];
    }

    /**
     * Estilos para encabezados y celdas específicas.
     *
     * @param Worksheet $sheet
     * @return void
     */
    public function styles(Worksheet $sheet)
    {
        // Aplicar fuente Abadi para toda la hoja y centrar el contenido
        $sheet->getStyle('A:E')->applyFromArray([
            'font' => [
                'name' => 'Abadi',
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
    }

    /**
     * Mapeo de datos para cada fila.
     *
     * @param mixed $estudiante
     * @return array
     */
    public function map($estudiante): array
    {
        return [
            $estudiante->cif,
            "{$estudiante->nombre} {$estudiante->apellido}",
            $estudiante->carrera ? $estudiante->carrera->nombre : 'Sin asignar',
            $estudiante->email,
            $estudiante->status ? 'Activo' : 'Inactivo',
        ];
    }

    /**
     * Eventos para agregar el título y aplicar estilos.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                // Mover los datos hacia abajo para insertar el título
                $sheet->insertNewRowBefore(1, 1);
                $sheet->setCellValue('A1', 'Reporte de estudiantes de UAM Emprende');

                // Aplicar estilo al título
                $sheet->mergeCells('A1:E1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                        'name' => 'Abadi',
                        'color' => ['argb' => 'FF000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Estilos de encabezados
                $sheet->getStyle('A2:E2')->applyFromArray([
                    'font' => [
                        'size' => 12,
                        'name' => 'Abadi',
                        'color' => ['argb' => 'FF000000'], // Color negro para que sea legible
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFCCE5FF'], // Color cyan suave para el encabezado
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Colorear estudiantes inactivos en rojo claro, a partir de la fila 3
                $highestRow = $sheet->getHighestRow();
                for ($row = 3; $row <= $highestRow; $row++) {
                    $cell = $sheet->getCell("E{$row}");
                    if ($cell->getValue() === 'Inactivo') {
                        $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFFFE0E0'], // Color rojizo claro para inactivos
                            ],
                            'alignment' => [
                                'horizontal' => Alignment::HORIZONTAL_CENTER,
                                'vertical' => Alignment::VERTICAL_CENTER,
                            ],
                        ]);
                    }
                }

                // Total de estudiantes debajo de la tabla
                $totalEstudiantes = Estudiante::where('admin', false)->count();
                $filaTotal = $highestRow + 2;
                $sheet->setCellValue("A{$filaTotal}", 'Total de Estudiantes');
                $sheet->setCellValue("B{$filaTotal}", $totalEstudiantes);
                $sheet->getStyle("A{$filaTotal}:B{$filaTotal}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'name' => 'Abadi',
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Estadísticas de distribución de carreras
                $estudiantesPorCarrera = Estudiante::with('carrera')
                    ->selectRaw('carrera_id, count(*) as total')
                    ->where('admin', false)
                    ->groupBy('carrera_id')
                    ->get();
                $fila = $filaTotal + 3;

                $sheet->setCellValue("A{$fila}", 'Distribución de Estudiantes por Carrera');
                $sheet->getStyle("A{$fila}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'name' => 'Abadi',
                        'color' => ['argb' => 'FF000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
                $fila++;

                foreach ($estudiantesPorCarrera as $carrera) {
                    $nombreCarrera = $carrera->carrera ? $carrera->carrera->nombre : 'Sin asignar';
                    $sheet->setCellValue("A{$fila}", $nombreCarrera);
                    $sheet->setCellValue("B{$fila}", $carrera->total);
                    $sheet->getStyle("A{$fila}:B{$fila}")->applyFromArray([
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ]);
                    $fila++;
                }

                // Distribución porcentual de estatus
                $activos = Estudiante::where('status', true)->where('admin', false)->count();
                $inactivos = Estudiante::where('status', false)->where('admin', false)->count();
                $total = $activos + $inactivos;
                $fila += 2;

                $sheet->setCellValue("A{$fila}", 'Distribución Porcentual de Estatus');
                $sheet->getStyle("A{$fila}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'name' => 'Abadi',
                        'color' => ['argb' => 'FF000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $sheet->setCellValue("A" . ($fila + 1), 'Activo');
                $sheet->setCellValue("B" . ($fila + 1), round(($activos / $total) * 100, 2) . '%');
                $sheet->setCellValue("A" . ($fila + 2), 'Inactivo');
                $sheet->setCellValue("B" . ($fila + 2), round(($inactivos / $total) * 100, 2) . '%');
                $sheet->getStyle("A" . ($fila + 1) . ":B" . ($fila + 2))->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Ajuste automático de las columnas
                foreach (range('A', 'E') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
