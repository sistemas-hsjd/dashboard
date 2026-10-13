<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('login_locations', function (Blueprint $table) {
            $table->string('operating_system', 64)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('login_locations', function (Blueprint $table) {
            $table->dropColumn('operating_system');
        });
    }
};
