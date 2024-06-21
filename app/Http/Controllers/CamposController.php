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
        $campoFormularios = CampoFormulario::all();
        $formularios = Formulario::all();

        return view('formularios', compact('campoFormularios', 'formularios'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'resp' => 'required|string',
            'tipo' => 'required|string|in:texto,textoarea,multiplo',

        ]);

        RespFormulario::create([
            'resp' => $validatedData['resp'],
            'tipo' => $validatedData['tipo']
        ]);

        return redirect('formularios');
    }

    public function show($id)
    {
        $ordemTipos = [
            'texto' => 1,
            'textoarea' => 2,
            'multiplo' => 3,
        ];

        $formulario = Formulario::find($id);
        $campoFormulario = CampoFormulario::where('formulario_id', $id)->orderBy('id', 'asc')->get();
        $campoFormulario = $campoFormulario->sortBy(function($campo) use ($ordemTipos) {
            return $ordemTipos[$campo->tipo];
        });

        return view('formularios', compact('campoFormulario', 'formulario'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
