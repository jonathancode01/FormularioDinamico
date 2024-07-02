<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampoFormulario;
use App\Models\Formulario;
use App\Models\RespFormulario;

class CamposController extends Controller
{

    public function index()
    {
        $camposFormularios = CampoFormulario::all();
        return view('formularios', compact('camposFormularios'));
    }
    public function store(Request $request, $id)
    {
        $formulario = Formulario::find($id);

        if (!$formulario) {
            return response()->json(['message' => 'Formulário não encontrado'], 404);
        }

        foreach ($request->input('campos') as $campo) {
            $request->validate([
                'campos.*.resp' => 'required|string',
                'campos.*.tipo' => 'required|string|in:texto,textoarea,select',
            ]);

            RespFormulario::create([
                'resp' => $campo['resp'],
                'resp_tipo' => $campo['tipo'],
                'formulario_id' => $id,
            ]);
        }

        return redirect()->route('formularios');
    }

    public function show($id)
    {
        $formularios = Formulario::with('campos.selects')->findOrFail($id);
        return view('formularios', compact('formularios'));
    }
}
