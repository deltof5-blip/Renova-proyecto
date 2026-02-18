<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsuariosBaseSeeder::class,
            MarcasBaseSeeder::class,
            ModelosBaseSeeder::class,
            MovilSeeder::class,
            CategoriaSeeder::class,
            ComponentesSeeder::class,
            PedidosSeeder::class,
            ReparacionesPabloSeeder::class,
        ]);
    }
}
