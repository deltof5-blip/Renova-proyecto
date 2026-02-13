<?php

namespace Database\Seeders;

use App\Models\Modelo;
use App\Models\Movil;
use Illuminate\Database\Seeder;

class MovilSeeder extends Seeder
{
    public function run(): void
    {
        $colores = ['Negro', 'Blanco', 'Azul', 'Rojo', 'Gris', 'Verde'];
        $grados = ['S', 'A+', 'A', 'B'];
        $almacenamientos = [128, 256, 512, 1024];

        Movil::query()->delete();

        $modelos = Modelo::all();
        foreach ($modelos as $modelo) {
            foreach ($colores as $color) {
                foreach ($grados as $grado) {
                    foreach ($almacenamientos as $almacenamiento) {
                        $semilla = crc32($modelo->id . '|' . $color . '|' . $grado . '|' . $almacenamiento);
                        $incluir = ($semilla % 100) < 58;

                        $esVarianteBase = $color === 'Negro' && in_array($grado, ['S', 'A+'], true) && in_array($almacenamiento, [128, 256], true);
                        if (! $incluir && ! $esVarianteBase) {
                            continue;
                        }

                        $stock = $semilla % 27;

                        Movil::updateOrCreate(
                            [
                                'modelo_id' => $modelo->id,
                                'color' => $color,
                                'grado' => $grado,
                                'almacenamiento' => $almacenamiento,
                            ],
                            [
                                'stock' => $stock,
                            ]
                        );
                    }
                }
            }
        }
    }
}
