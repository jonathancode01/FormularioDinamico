<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampoFormulario;
use App\Models\Formulario;
use App\Models\RespFormulario;

/**
 * @OA\Tag(
 *     name="Campos",
 *     description="Gerenciamento de campos e respostas de formulários"
 * )
 */
class CamposController extends Controller
{
    /**
     * @OA\Get(
     *     path="/campos",
     *     tags={"Campos"},
     *     summary="Lista todos os campos e respostas de formulários",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de campos e respostas de formulários"
     *     )
     * )
     */
    public function index()
    {

    }

    /**
     * @OA\Post(
     *     path="/campos/{id}",
     *     tags={"Campos"},
     *     summary="Armazena respostas para um formulário específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do formulário",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="campos",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="resp", type="string"),
     *                     @OA\Property(property="tipo", type="string", enum={"texto", "textarea", "select"}),
     *                     @OA\Property(property="campo_id", type="integer")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Respostas armazenadas com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dados de entrada inválidos"
     *     )
     * )
     */
	public function store(Request $request, $id)
	    {
		$formularioId = $id;

		// Validação dos dados recebidos do formulário
		$request->validate([
		    'campos.*.resp' => 'required|string',
		    'campos.*.tipo' => 'required|string|in:texto,textoarea,select',
		    'campos.*.campo_id' => 'required|exists:campos_formulario,id', // Adiciona validação para campo_id
		]);

		foreach ($request->input('campos') as $campo) {
		    RespFormulario::create([
		        'resp' => $campo['resp'],
		        'resp_tipo' => $campo['tipo'],
		        'formulario_id' => $formularioId,
		        'campo_id' => $campo['campo_id'], // Inclui o campo_id aqui
		    ]);
		}

		return redirect('/')->with('success', 'Respostas enviadas com sucesso!');
	    }

    /**
     * @OA\Get(
     *     path="/respostas/{id}",
     *     tags={"Campos"},
     *     summary="Exibe os detalhes de um formulário específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do formulário",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do formulário",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="formulario", type="object"),
     *             @OA\Property(property="campos", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="respostas", type="array", @OA\Items(type="object"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formulário não encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $formulario = Formulario::find($id);
        $respostas = RespFormulario::where('formulario_id', $id)->get(); // Corrigido aqui
        $campos = CampoFormulario::where('formulario_id', $id)->get();

        return view('respostas', compact('formulario', 'campos', 'respostas'));
    }

    /**
     * @OA\Post(
     *     path="/campos/search",
     *     tags={"Campos"},
     *     summary="Busca por formulários com base no título",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="search", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formulário encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="titulo", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nenhum formulário encontrado"
     *     )
     * )
     */
	public function search(Request $request)
	{
        dd($request->all());
        $search = $request->input('search');

        // Realiza a busca pelo título específico
        $formulario = Formulario::where('titulo', 'like', '%' . $search . '%')->first();

        if (!$formulario) {
            return response()->json(['message' => 'Nenhum formulário encontrado']);
        }

        return response()->json([
            'id' => $formulario->id,
            'titulo' => $formulario->titulo,
            // Adicione outros campos do formulário se necessário
        ]);
    }
}
