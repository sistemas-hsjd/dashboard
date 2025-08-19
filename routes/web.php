<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/iniciar-sesion', [AuthController::class, 'login'])->name('iniciarSesion');
    Route::get('/mail', [MailController::class, 'index']);
    Route::get('/get-jefatura', [DashboardController::class, 'getJefatura']); 
  
});

Route::middleware(['auth'])->group(function () {
    Route::get('/inicio', [DashboardController::class, 'showSistemas'])->name('misSistemas');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('api')->group(function () {
    // Route::get('/get-default', [DashboardController::class, 'getDefault']);
    Route::post('/abrir-access', [DashboardController::class, 'abrirMsaccess']);

    Route::post('/desactivar-enlaces', [DashboardController::class, 'desactivarEnlaces']);

    Route::post('/get-info', [DashboardController::class, 'getInfo']);
    Route::post('/solicitar-cuenta', [DashboardController::class, 'solicitarCuentas']);
    Route::post('/get-funcionarios', [DashboardController::class, 'getFuncionarios']);   
    
    Route::get('/get-enlaces', [DashboardController::class, 'getALLEnlaces']);   

    Route::post('/get-persona', [GeneralController::class, 'getPersona']);
    Route::post('/data-inicial', [GeneralController::class, 'getInfoInicial']);
    Route::post('/get-mis-sistemas', [DashboardController::class, 'getMisSistemas']); 
    Route::post('/get-tutor', [DashboardController::class, 'getTutor']);    
}); 

Route::get('{view}', ApplicationController::class)
->where('view', '^(?!api|login|iniciar-sesion|logout|inicio).*$');

Route::post('/data-auth', function() {
    $user = Auth::user();

    if ($user) {
        return response()->json([
            'authenticated' => true,
            'user' => Auth::user(),
            'jefatura' => Auth::user()->jefatura
        ]);
    } else {
        return response()->json([
            'authenticated' => false,
            'user' => null,
            'jefatura' => null
        ]);
    }
});

