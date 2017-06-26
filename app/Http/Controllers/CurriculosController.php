<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Curriculo;
use App\Area;
use App\Empresa;
use Datatables;

class CurriculosController extends Controller
{

    protected $mensagens = [
        'required' => 'O campo :attribute é obrigatório',
        'alpha'    => 'O campo Nome deve conter apenas letras',
    ];

    // Construtor com a instrução de manter as rotas desse controller protegidas pela autenticação

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obter todos os curriculos cadastrados

        $curriculos = Curriculo::all()->load('areas');
        
        // Criar um vetor associativo com o id do currículo e a idade da pessoa
        // Necessário para montar a tabela na view

        $idades = $this->calcularIdades($curriculos);

        return view('curriculos.index', compact(['curriculos', 'idades']));
    }

    /**
     * Mostra uma lista de currículos que já foram excluídos
     * usando SoftDeletes
     * 
     * @return \Illuminate\Http\Response
     */

    public function excluidos()
    {
        // Obter todos os currículos excluídos

        $excluidos = Curriculo::onlyTrashed()->get();
        $idades = $this->calcularIdades($excluidos);

        return view('curriculos.excluidos', compact(['excluidos', 'idades']));
    }

    /**
     * Mostra uma lista de currículos que já foram encaminhados
     * para empresas
     * 
     * @return \Illuminate\Http\Response
     */

    public function encaminhados()
    {
        // A função reject executa a closure e retira da coleção todos os objetos
        // para os quais ela retorna true.
        // Dessa forma, apenas os currículos que já foram encaminhados são retornados

        $curriculos = Curriculo::all()->reject(function($objeto, $chave){ 

            // Condição para que o objeto seja retirado da coleção

            return $objeto->encaminhado == null; 

        });

        return view('curriculos.encaminhados', compact(['curriculos']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Obter todas as áreas de atuação para enviar para o formulário

        $areas = Area::orderBy('descricao', 'asc')->get();

        return view('curriculos.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar os dados

        $this->validate($request, [
            'nome' => 'required|alpha_spaces',
            'cpf' => 'cpf',
            'rua' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
        ], $this->mensagens);

        $curriculo = new Curriculo($request->all());

        // Relacionar à área de atuação

        $curriculo->save();

        // Eliminar as posições vazias do vetor de áreas de atuação

        $areas_selecionadas = array_filter($request->input('area'));

        // Realizar o cadastro das áreas apenas se ainda houver alguma posição no vetor

        if(count($areas_selecionadas))

            $curriculo->areas()->attach($areas_selecionadas);

        // Retornar para o formulário de cadastro com mensagem de sucesso

        return redirect('curriculos/create')->with('mensagem', 'Currículo cadastrado com sucesso!');
    }

    /**
     * Restaurar currículo com softdelete
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */

    public function restaurar($id)
    {
        $curriculo = Curriculo::withTrashed()->find($id);

        $curriculo->restore();

        return redirect('/curriculos-excluidos');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $areas = Area::all();

        $curriculo = Curriculo::find($id);

        return view ('curriculos.edit', compact('areas', 'curriculo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Obter o currículo sendo editado

        $curriculo = Curriculo::find($id);

        // Validar os dados

        $this->validate($request, [
            'nome' => 'required',
            // 'cpf' => 'required',
            'rua' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            // 'titulo' => 'required',
            // 'area' => 'required',
            'sexo' => 'required',
        ], $this->mensagens);

        $curriculo->update($request->all());

        // Eliminar as posições vazias do vetor de áreas de atuação e reindexar começando do 0

        $areas_selecionadas = array_values(array_filter($request->input('area')));

        // Realizar o cadastro das áreas apenas se ainda houver alguma posição no vetor

        if(count($areas_selecionadas))

            // Aqui é usado o método sync ao invés do attach, dessa maneira
            // apenas os ID's fornecidos serão salvos no banco de dados,
            // todos os outros serão excluídos

            $curriculo->areas()->sync($areas_selecionadas);

        return redirect('curriculos/'.$id."/edit")->with('mensagem', 'Currículo alterado com sucesso.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Obter o currículo com o ID fornecido

        $curriculo = Curriculo::find($id);

        // Gravar o ID do usuário que excluiu o currículo

        $curriculo->quem_deletou()->associate(Auth::user());
        $curriculo->save();

        // Destruí-lo

        $curriculo->delete();

        // O redirect será feito via JavaScript
    }

    /**
     * Excluir permanentemente um curriculo que já está na lista de softDeletes
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function excluir($id)
    {
        $curriculo = Curriculo::withTrashed()->find($id);

        $curriculo->forceDelete();

        // O redirect será feito via JavaScript
    }

    /**
     * Encaminhar currículos para as empresas
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function encaminhar(Request $request)
    {
        $ids = $request->input('ids');
        $desc_empresa = $request->input('empresa');

        // Obter a empresa no banco de dados ou criar uma nova
        // caso não exista

        $empresa = Empresa::firstOrCreate(['descricao' => $desc_empresa]);

        // Relacionar o currículo à empresa indicada

        $teste = [];

        foreach ($ids as $id) 
        {
            $curriculo = Curriculo::find($id);

            $curriculo->empresa()->associate($empresa);
            $curriculo->save();

        }

        return 1;
    }

    /**
     * Eliminar o campo encaminhado, para que o currículo volte a aparecer na lista
     * de currículos disponíveis
     *
     * @param  int $id
     */

    public function retornar($id)
    {
        $curriculo = Curriculo::find($id);
        $curriculo->encaminhado = null;
        $curriculo->save();

        return redirect('/curriculos-encaminhados');
    }

    /**
     * Criar um PDF para exibição / impressão do currículo
     * 
     * @param in $id
     * @return Arquivo PDF
     */

    public function pdf($id)
    {
        $curriculo = Curriculo::find($id);

        $pdf = PDF::loadView('pdf.curriculo', compact('curriculo'));

        return $pdf->stream();
    }

    /**
     * Calcular a idade de cada inscrito
     */

    protected function calcularIdades($curriculos)
    {
        $idades = [];

        foreach($curriculos as $curriculo)
        {
            $nascimento = date('Y', strtotime(implode(array_reverse(explode('/',$curriculo->nascimento)))));
            $idade = date('Y') - $nascimento;

            $idades[$curriculo->id] = $idade;
        }

        return $idades;
    }

    /**
     * Montar a tabela de currículos
     */

    public function dataTables()
    {
        // Obter todos os currículos com as áreas de atuação relacionadas

        $curriculos = Curriculo::with('areas')->get();

        // Calcular as idades de cada currículo

        $idades = $this->calcularIdades($curriculos);

        // Criar o objeto da coleção que será usado para o dataTables

        $colecao = collect();

        // Iterar pelos currículos e montar cada linha da tabela

        foreach($curriculos as $curriculo)
        {
            // Concatenar as áreas de atuação

            $areas = "";

            foreach($curriculo->areas as $area)
            {
                $areas += $area." ";
            }

            // Colunas de HTML

            $encaminhar = "<input type='checkbox' class='flat chk-encaminhar' name='encaminhar' data-id='$curriculo->id' data-nome='$curriculo->nome'>";

            $acoes = "<a href='".url("curriculos/pdf/$curriculo->id")." target='_blank' class='btn btn-success btn-ver' data-id='$curriculo->id'><i class='fa fa-eye'></i></a>";

            $colecao->push([
                'nome'       => $curriculo->nome,
                'idade'      => $idades[$curriculo->id],
                'sexo'       => $curriculo->sexo == "M" ? "Masculino" : "Feminino",
                'bairro'     => $curriculo->bairro,
                'formacao'   => $curriculo->formacao,
                'area'       => $areas,
                'indicacao'  => $curriculo->indicacao_politica ? "Sim" : "Não",
                'encaminhar' => $encaminhar,
                'acoes'      => $acoes,

            ]);
        }

        // Retornar a tabela pronta

        return Datatables::of($colecao)
        ->rawColumns(['encaminhar', 'acoes'])
        ->make(true);
    }

    /**
     * função para mostrar a tela de relatorio
     */

    public function relatorios(Request $request) {

        return view ("curriculos.relatorio.geral");
    }
}
