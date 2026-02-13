<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('pedidos', 'dni')) {
            Schema::table('pedidos', function (Blueprint $table) {
                $table->string('dni', 9)->nullable()->after('apellidos');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pedidos', 'dni')) {
            Schema::table('pedidos', function (Blueprint $table) {
                $table->dropColumn('dni');
            });
        }
    }
};
