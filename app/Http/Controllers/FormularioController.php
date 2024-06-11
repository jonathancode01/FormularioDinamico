<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\CampoFormulario;

class FormularioController extends Controller {

    public function index(){

        $formularios = Formulario::all();
        return view ('welcome', compact('formularios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string',


        ]);
        try {
            Log::info('Request received: ', $request->all());

            $formulario = Formulario::create([
                'titulo' => $request->input('titulo')
            ]);

            if (!$formulario){
                throw new \Exception('Formulario não encontrado');
            }

            foreach ($request->input('campos', []) as $campo) {
                Log::info('Processing campo: ', $campo);
                CampoFormulario::create([
                    'formulario_id' => $formulario->id,
                    'titulo' => $campo['titulo'] ?? '',
                ]);
            }

            Log::info('Formulario criado com sucesso!');
            return response()->json(['message' => $formulario->id], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao salvar o formulario: ', ['error ' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);


            }
        }

    public function show($id){

        $formularios = Formulario::find($id);

        $campos = $formularios->campos;


        return view ('/formularios', compact('campos'));
    }
}
