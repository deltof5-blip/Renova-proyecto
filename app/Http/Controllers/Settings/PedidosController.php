<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PedidosController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $pedidos = Pedido::with('productos')
            ->where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($pedido) {
                return [
                    'id' => $pedido->id,
                    'estado' => $pedido->estado,
                    'total' => (float) $pedido->total,
                    'fecha' => $pedido->created_at?->format('d/m/Y H:i'),
                    'productos' => $pedido->productos->map(function ($producto) {
                        return [
                            'id' => $producto->id,
                            'nombre' => $producto->nombre,
                            'cantidad' => $producto->cantidad,
                            'precio_unitario' => (float) $producto->precio_unitario,
                            'datos' => $producto->datos,
                        ];
                    }),
                ];
            });

        return Inertia::render('settings/pedidos', [
            'pedidos' => $pedidos,
        ]);
    }

}
