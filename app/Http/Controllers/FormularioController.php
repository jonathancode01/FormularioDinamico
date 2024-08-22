<?php

namespace App\Http\Controllers;

use App\Models\CampoFormulario;
use App\Models\RespFormulario;
use App\Models\SelectModel;
use App\Models\Formulario;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
/**
 * @OA\Tag(
 *     name="Formularios",
 *     description="Gerenciamento de formulários"
 * )
 */
class FormularioController extends Controller
{
    /**
     * @OA\Get(
     *     path="/",
     *     tags={"Formularios"},
     *     summary="Lista todos os formulários",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de formulários"
     *     )
     * )
     */
    public function index()
    {
        $formularios = Formulario::all();
        $campoFormularios = CampoFormulario::all();
        return view('welcome', compact('formularios'));
    }

    /**
     * @OA\Post(
     *     path="/formularios",
     *     tags={"Formularios"},
     *     summary="Cria um novo formulário",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="titulo", type="string"),
     *             @OA\Property(
     *                 property="campos",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="titulo", type="string"),
     *                     @OA\Property(property="tipo", type="string", enum={"texto", "textarea", "select"}),
     *                     @OA\Property(property="options", type="array", @OA\Items(type="string"))
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Formulário criado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dados de entrada inválidos"
     *     )
     * )
     */
    public function store(Request $request)
    {
        Log::info('Request data: ', $request->all());

        // Validação dos dados recebidos do formulário
        $validatedData = $request->validate([
            'titulo' => 'required|string',
            'campos' => 'required|array',
            'campos.*.titulo' => 'required|string',
            'campos.*.tipo' => 'required|string|in:texto,textoarea,select',
            'campos.*.options.*' => 'string',
            'campos.*.options' => 'nullable|array',
        ]);

        Log::info('Validated data: ', $validatedData);

        // Criar o formulário principal
        $formulario = Formulario::create([
            'titulo' => $request->input('titulo'),
        ]);

        Log::info('Formulario created: ', $formulario->toArray());

        // Verificar se o formulário foi criado com sucesso
        if ($formulario) {
            // Criar os campos do formulário
            foreach ($request->input('campos') as $campo) {
                $novoCampo = CampoFormulario::create([
                    'formulario_id' => $formulario->id,
                    'titulo' => $campo['titulo'],
                    'tipo' => $campo['tipo'],
                ]);
                Log::info('Campo created: ', $novoCampo->toArray());

                // Criar as opções se o campo for do tipo select
                if ($campo['tipo'] === 'select' && isset($campo['options'])) {
                    foreach ($campo['options'] as $option) {
                        $newOption = SelectModel::create([
                            'campo_formulario_id' => $novoCampo->id,
                            'option_text' => $option,
                        ]);
                        Log::info('Option created: ', $newOption->toArray());
                    }
                }
            }
            // Redirecionar para a página de detalhes do formulário
            return response()->json(['message' => $formulario->id]);
        }
        // Em caso de falha ao criar o formulário, retornar uma resposta de erro
        return back()->withInput()->withErrors(['message' => 'Erro ao criar o formulário']);
    }

    /**
     * @OA\Get(
     *     path="/formularios/{id}",
     *     tags={"Formularios"},
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
        $campos = CampoFormulario::where('formulario_id', $id)->get();
        $respostas = RespFormulario::where('formulario_id', $id)->get(); // Corrigido aqui
        return view('formularios', compact('formulario', 'campos', 'respostas')); // Incluindo $respostas
    }

    /**
     * @OA\Post(
     *     path="/formularios/search",
     *     tags={"Formularios"},
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
        $search = $request->input('search');

        // Realiza a busca pelos formulários cujo título corresponde ao termo de busca
        $formularios = Formulario::where('titulo', 'like', '%' . $search . '%')->first();
        // procurar por um formulário na tabela "formularios" onde o titulo corresponda ao termo de busca, e o like busca pelo termo de busca,
        // e o % indica que o termo de busca pode estar em qualquer parte do campo

        if (!$formularios) {
            return response()->json(['message' => 'Nenhum formulário encontrado']);
        }

        return response()->json($formularios);

    }
}
