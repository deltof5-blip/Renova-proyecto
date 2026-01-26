<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Support\Colores;
use Inertia\Inertia;
use Laravel\Fortify\Features;

class HomeController extends Controller
{
    use Colores;

    public function index()
    {
        $modelos = Modelo::with('marca')
            ->orderByDesc('id')
            ->take(9)
            ->get();

        $colores = $this->ponerColores($modelos->pluck('id')->all());
        return Inertia::render('home', [
            'canRegister' => Features::enabled(Features::registration()),
            'modelos' => $modelos->map(function ($modelo) use ($colores) {
                return [
                    'id' => $modelo->id,
                    'nombre' => trim($modelo->marca->nombre . ' ' . $modelo->nombre),
                    'precio' => $modelo->precio_base,
                    'imagen' => null,
                    'coloresDisponibles' => $colores[$modelo->id] ?? [],
                ];
            }),
        ]);
    }
}
