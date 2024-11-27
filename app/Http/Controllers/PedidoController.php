<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Emprendimiento;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoCreado;
use App\Mail\PedidoActualizado;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
class PedidoController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos del pedido
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'emprendimiento_id' => 'required|exists:emprendimientos,id',
            'mensaje' => 'required|string|max:500',
        ]);

        $pedido = Pedido::create($validated);
        //Pedido::create($validated);

        $emprendimiento = Emprendimiento::find($validated['emprendimiento_id']);
        Mail::to($emprendimiento->emprendedor->email)->send(new PedidoCreado($pedido));

        // Redireccionar con un mensaje de éxito
        return redirect()->back()->with('success', 'Pedido enviado exitosamente. El emprendedor revisará tu solicitud.');
    }

    public function index(Request $request)
    {
        // Obtenemos el estado del filtro desde la solicitud
        $estado = $request->query('estado');

        // Filtramos los pedidos según el estado
        $query = Pedido::whereHas('emprendimiento', function($query) {
            $query->where('emprendedor_id', auth()->id());
        });

        if (!empty($estado)) {
            $query->where('estado', $estado);
        }

        $pedidos = $query->get();

        // Retornamos la vista con los pedidos filtrados
        return view('pedidos.index', compact('pedidos'));
    }


    public function update(Request $request, Pedido $pedido)
    {
        $validated = $request->validate([
            'estado' => 'required|in:aceptado,rechazado',
            'razon' => 'nullable|string|max:500',
        ]);
        $pedido->update(['estado' => $request->estado]);

        Mail::to($pedido->estudiante->email)->send(new PedidoActualizado($pedido, $validated['razon'] ?? ''));

        return redirect()->route('pedidos.index')->with('success', 'El pedido ha sido actualizado.');
    }

    public function exportarPDF()
    {
        // Obtener los pedidos pendientes del emprendedor actual
        $pedidos = Pedido::whereHas('emprendimiento', function($query) {
            $query->where('emprendedor_id', auth()->id());
        })->where('estado', 'pendiente')->get();

        // Generar el PDF
        $pdf = PDF::loadView('pedidos.pedidos_pdf', compact('pedidos'));

        // Retornar el PDF como descarga
        return $pdf->download('pedidos_pendientes.pdf');
    }
    //
}
