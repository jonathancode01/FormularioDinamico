<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\CampoFormulario;

class FormularioController extends Controller
{
    public function index()
    {
        $formulario = Formulario::all();
        return view('welcome', ['formularios' => $formulario]);
    }

    public function store(Request $resquest){

        $validatedData = $resquest->validate([
            'titulo' => 'required|string|max:255',
            'campos' => 'required|array',
            'campos.*.texto' => 'nullable|string',
            'campos.*.textoarea' => 'nullable|string',
            'campos.*.multiplo' => 'nullable|boolean',

        ]);

        $formulario = Formulario::create([
            'titulo' => $validatedData['titulo'],
        ]);

        foreach ($validatedData['campos'] as $campoData) {
            CampoFormulario::create([
                'formulario_id' => $formulario->id,
                'texto' => $campoData['texto'] ?? '',
                'textoarea' => $campoData['textoarea'] ?? '',
                'multiplo' => $campoData['multiplo'] ?? false,
            ]);
        }

        return redirect('/formularios');
    }
}
