<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('login_locations', function (Blueprint $table) {
            $table->string('nombre_completo')->nullable();
            $table->string('rut', 32)->nullable()->index();
            $table->json('unidades')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('login_locations', function (Blueprint $table) {
            $table->dropIndex(['rut']);
            $table->dropColumn(['nombre_completo', 'rut', 'unidades']);
        });
    }
};
