<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioController;

Route::get('/', [FormularioController::class, 'index']);
Route::post('/formularios', [FormularioController::class, 'store']);
Route::get('/formularios/{id}', [FormularioController::class, 'show']);

