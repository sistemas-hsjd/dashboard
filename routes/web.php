<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\GeneralController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🔐 Rutas para usuarios NO autenticados (guest)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/iniciar-sesion', [AuthController::class, 'login'])->name('iniciarSesion');
});

// 🔐 Rutas protegidas para usuarios autenticados
Route::middleware(['auth'])->group(function () {
    Route::get('/inicio', [DashboardController::class, 'showSistemas'])->name('misSistemas');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Aquí puedes colocar más rutas protegidas si lo deseas
});

// 📡 Rutas tipo API (no requieren autenticación en este caso)
Route::prefix('api')->group(function () {
    Route::post('/get-info', [DashboardController::class, 'getInfo']);
    Route::post('/solicitar-cuenta', [DashboardController::class, 'solicitarCuentas']);
    Route::post('/get-funcionarios', [DashboardController::class, 'getFuncionarios']);   
    Route::post('/get-persona', [GeneralController::class, 'getPersona']);
    Route::post('/data-inicial', [GeneralController::class, 'getInfoInicial']);

    Route::post('/get-mis-sistemas', [DashboardController::class, 'getMisSistemas']); 
});

// 🌐 Catch-all para rutas frontend SPA (Vue/React), después de todas las rutas importantes
Route::get('{view}', ApplicationController::class)
    ->where('view', '^(?!api|login|iniciar-sesion|logout|inicio).*$');
