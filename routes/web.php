<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('principal');
// });

// Route::get('/', [DashboardController::class, 'index']);
Route::get('{view}', ApplicationController::class)->where('view', '^(?!api).*$');

// Route::get('/inicio', function () {
//         return view('contenido.contenido');
// })->name('inicio');

 Route::prefix('api')->group(function () {
     Route::post('/get-info', [DashboardController::class, 'getInfo']);
 });