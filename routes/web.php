<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\CamposController;


Route::get('/formularios', [CamposController::class, 'index']);
Route::get('/formularios/{id}', [FormularioController::class, 'show']);

Route::get('/', [FormularioController::class, 'index']);
Route::post('/formularios', [FormularioController::class, 'store']);
