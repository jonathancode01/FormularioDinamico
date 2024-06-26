<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\CamposController;


Route::post('/formularios/{id}', [CamposController::class, 'store']);
Route::get('/formularios/{id}', [CamposController::class, 'show']);



Route::get('/', [FormularioController::class, 'index']);
Route::post('/', [FormularioController::class, 'store']);

