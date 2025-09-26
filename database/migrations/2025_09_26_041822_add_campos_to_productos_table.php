<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->string('codigo')->unique()->after('id');
            $table->string('fotografia')->nullable()->after('stock');
            $table->date('fecha_ingreso')->nullable()->after('fotografia');
            $table->date('fecha_vencimiento')->nullable()->after('fecha_ingreso');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['codigo', 'fotografia', 'fecha_ingreso', 'fecha_vencimiento']);
        });
    }
};
