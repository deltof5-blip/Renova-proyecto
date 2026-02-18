<?php

namespace Database\Seeders;

use App\Models\Presupuesto;
use App\Models\SolicitudReparacion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ReparacionesPabloSeeder extends Seeder
{
    public function run(): void
    {
        $cliente = User::firstOrCreate(
            ['email' => 'pablo@renova.com'],
            [
                'name' => 'Pablo Renova',
                'password' => Hash::make('pablopablo'),
                'rol' => 'cliente',
            ]
        );

        $tecnico = User::where('rol', 'tecnico')->first();
        if (! $tecnico) {
            $tecnico = User::create([
                'name' => 'Tecnico Demo',
                'email' => 'tecnico.demo@renova.com',
                'password' => Hash::make('pablopablo'),
                'rol' => 'tecnico',
            ]);
        }

        $objetivoSolicitudes = 100;
        $existentes = SolicitudReparacion::where('user_id', $cliente->id)->count();
        $porCrear = max(0, $objetivoSolicitudes - $existentes);

        if ($porCrear === 0) {
            return;
        }

        $modelos = [
            'iPhone 11', 'iPhone 12', 'iPhone 13', 'iPhone 14', 'iPhone 15',
            'Galaxy S21', 'Galaxy S22', 'Galaxy S23', 'Galaxy S24',
            'Xiaomi 12', 'Xiaomi 13', 'Redmi Note 12', 'Redmi Note 13',
            'OnePlus 10', 'OnePlus 11', 'OnePlus 12',
        ];
        $problemas = [
            'Pantalla rota',
            'Batería degradada',
            'No carga',
            'No enciende',
            'Cámara borrosa',
            'Altavoz distorsionado',
            'Puerto de carga dañado',
            'Reinicio en bucle',
        ];
        $estados = ['nueva', 'asignado', 'presupuesto_enviado', 'aceptada', 'reparado', 'enviado', 'recibido', 'rechazada'];

        for ($i = 0; $i < $porCrear; $i++) {
            $fecha = Carbon::now()
                ->subMonths(rand(0, 42))
                ->subDays(rand(0, 27))
                ->setTime(rand(9, 20), rand(0, 59), rand(0, 59));

            $estado = $estados[array_rand($estados)];
            $tecnicoId = in_array($estado, ['nueva'], true) ? null : $tecnico->id;

            $solicitud = SolicitudReparacion::create([
                'user_id' => $cliente->id,
                'tecnico_id' => $tecnicoId,
                'nombre_completo' => 'Pablo Renova',
                'telefono' => '600000000',
                'email' => $cliente->email,
                'modelo_dispositivo' => $modelos[array_rand($modelos)],
                'tipo_problema' => $problemas[array_rand($problemas)],
                'descripcion' => 'Solicitud de prueba para contabilidad y flujo de reparaciones.',
                'modalidad' => rand(0, 1) ? 'envio' : 'recogida',
                'estado' => $estado,
                'created_at' => $fecha,
                'updated_at' => $fecha,
            ]);

            // Presupuesto solo en estados donde ya procede.
            if (in_array($estado, ['presupuesto_enviado', 'aceptada', 'reparado', 'enviado', 'recibido', 'rechazada'], true)) {
                $estadoPresupuesto = 'pendiente';
                if (in_array($estado, ['aceptada', 'reparado', 'enviado', 'recibido'], true)) {
                    $estadoPresupuesto = 'aceptado';
                } elseif ($estado === 'rechazada') {
                    $estadoPresupuesto = 'rechazado';
                }

                $fechaPresupuesto = $fecha->copy()->addDays(rand(1, 4));

                Presupuesto::create([
                    'solicitud_reparacion_id' => $solicitud->id,
                    'tecnico_id' => $tecnico->id,
                    'importe_total' => round(rand(2500, 45000) / 100, 2),
                    'descripcion' => 'Presupuesto de prueba para reparación.',
                    'estado' => $estadoPresupuesto,
                    'created_at' => $fechaPresupuesto,
                    'updated_at' => $fechaPresupuesto,
                ]);
            }
        }
    }
}

