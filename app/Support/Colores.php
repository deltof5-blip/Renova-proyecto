<?php

namespace App\Support;

use App\Models\Movil;
trait Colores
{
    private function ponerColores(array $modelosIds): array
    {
        if (count($modelosIds) === 0) {
            return [];
        }

        return Movil::query()
            ->whereIn('modelo_id', $modelosIds)
            ->get()
            ->groupBy('modelo_id')
            ->map(function ($group) {
                return $group->pluck('color')->unique()->values()->all();
            })
            ->toArray();
    }
}
