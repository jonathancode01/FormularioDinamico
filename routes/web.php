<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\CamposController;


Route::post('/formularios/store', [CamposController::class, 'store']);
Route::get('/formularios/{id}', [CamposController::class, 'show']);


Route::get('/formularios', [CamposController::class, 'index']);

Route::get('/', [FormularioController::class, 'index']);
Route::post('/formularios', [FormularioController::class, 'store']);


