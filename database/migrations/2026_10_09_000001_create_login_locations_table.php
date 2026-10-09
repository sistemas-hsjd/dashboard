<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_locations', function (Blueprint $table) {
            $table->id();
            // Users authenticate against the separate generales connection.
            $table->unsignedBigInteger('user_id')->index();
            $table->ipAddress('ip_address');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->double('accuracy_meters')->nullable();
            $table->string('location_status', 32);
            $table->timestamp('logged_in_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_locations');
    }
};
