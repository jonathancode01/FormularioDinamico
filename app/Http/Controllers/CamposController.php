<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampoFormulario;

class CamposController extends Controller
{

    public function index()
    {
        $campoFormularios = campoFormulario::all();
        return view('formularios', compact('campoFormularios'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
    }


    public function show($id){
        $campoFormulario = campoFormulario::find($id);
        $formulario = $campoFormulario->formulario;

        $campos = $formulario->campos;

        return view ('/formularios', compact('campos'));
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
