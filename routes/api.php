<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\CamposController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', [FormularioController::class, 'index']);
Route::post('/formularios', [FormularioController::class, 'store'])->name('formularios');
Route::get('/formularios/{id}', [FormularioController::class, 'show']);
Route::get('/respostas/{id}', [CamposController::class, 'show'])->name('campos.show');
Route::post('/formularios/{id}/campos', [CamposController::class, 'store'])->name('campos.store');
Route::post('/search', [FormularioController::class, 'search'])->name('search');

