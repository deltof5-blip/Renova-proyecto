<?php

namespace Database\Seeders;

use App\Models\Componente;
use App\Models\Movil;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class PedidosSeeder extends Seeder
{
    public function run(): void
    {
        $usuario = User::firstOrCreate(
            ['email' => 'pablo@renova.com'],
            [
                'name' => 'Pablo Renova',
                'password' => Hash::make('pablopablo'),
                'rol' => 'cliente',
            ]
        );

        $objetivoPedidosPagados = 120;
        $existentesPagados = Pedido::where('user_id', $usuario->id)
            ->where('estado', 'pagado')
            ->count();

        $porCrear = max(0, $objetivoPedidosPagados - $existentesPagados);
        if ($porCrear === 0) {
            return;
        }

        $moviles = Movil::with('modelo.marca')->inRandomOrder()->take(30)->get();
        $componentes = Componente::inRandomOrder()->take(30)->get();

        for ($i = 0; $i < $porCrear; $i++) {
            $fechaBase = Carbon::now()
                ->subMonths(rand(0, 42))
                ->subDays(rand(0, 27))
                ->setTime(rand(9, 21), rand(0, 59), rand(0, 59));

            $estadoEnvio = ['pendiente', 'enviado', 'entregado'][rand(0, 2)];
            $pedido = Pedido::create([
                'user_id' => $usuario->id,
                'estado' => 'pagado',
                'estado_envio' => $estadoEnvio,
                'total' => 0,
                'stripe_sesion_id' => null,
                'nombre' => 'Pablo',
                'apellidos' => 'Renova',
                'dni' => '12345678Z',
                'telefono' => '600000000',
                'direccion' => 'Calle Demo 123',
                'ciudad' => 'Sevilla',
                'provincia' => 'Sevilla',
                'codigo_postal' => '41001',
                'enviado_at' => $estadoEnvio !== 'pendiente' ? $fechaBase->copy()->addDay() : null,
                'recibido_at' => $estadoEnvio === 'entregado' ? $fechaBase->copy()->addDays(3) : null,
                'created_at' => $fechaBase,
                'updated_at' => $fechaBase,
            ]);

            $lineas = rand(1, 4);
            $totalPedido = 0.0;

            for ($j = 0; $j < $lineas; $j++) {
                $usarMovil = rand(0, 1) === 1 && $moviles->isNotEmpty();

                if ($usarMovil) {
                    $movil = $moviles->random();
                    $nombreMovil = trim(
                        (($movil->modelo?->marca?->nombre ?? '') . ' ' . ($movil->modelo?->nombre ?? 'Movil'))
                    );
                    $precio = round(rand(12000, 90000) / 100, 2);
                    $cantidad = rand(1, 2);

                    PedidoProducto::create([
                        'pedido_id' => $pedido->id,
                        'producto_type' => Movil::class,
                        'producto_id' => $movil->id,
                        'nombre' => $nombreMovil,
                        'precio_unitario' => $precio,
                        'cantidad' => $cantidad,
                        'datos' => [
                            'color' => $movil->color,
                            'grado' => $movil->grado,
                            'almacenamiento' => $movil->almacenamiento,
                        ],
                        'created_at' => $fechaBase,
                        'updated_at' => $fechaBase,
                    ]);

                    $totalPedido += $precio * $cantidad;
                    continue;
                }

                $componente = $componentes->isNotEmpty() ? $componentes->random() : null;
                $precio = round(rand(800, 22000) / 100, 2);
                $cantidad = rand(1, 3);

                PedidoProducto::create([
                    'pedido_id' => $pedido->id,
                    'producto_type' => Componente::class,
                    'producto_id' => $componente?->id ?? 1,
                    'nombre' => $componente?->nombre ?? 'Componente genérico',
                    'precio_unitario' => $precio,
                    'cantidad' => $cantidad,
                    'datos' => null,
                    'created_at' => $fechaBase,
                    'updated_at' => $fechaBase,
                ]);

                $totalPedido += $precio * $cantidad;
            }

            $pedido->total = round($totalPedido, 2);
            $pedido->save();
        }
    }
}
