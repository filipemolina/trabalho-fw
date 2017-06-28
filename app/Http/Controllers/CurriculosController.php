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

        // Obter todas as áreas de atuação

        $areas = Area::all();
        
        // Criar um vetor associativo com o id do currículo e a idade da pessoa
        // Necessário para montar a tabela na view

        $idades = $this->calcularIdades($curriculos);

        return view('curriculos.index', compact(['curriculos', 'idades', 'areas']));
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
                $areas .= $area->descricao." ";
            }

            // Colunas de HTML

            $encaminhar = "<input type='checkbox' class='flat chk-encaminhar' name='encaminhar' data-id='$curriculo->id' data-nome='$curriculo->nome'>";

            $acoes = "<a href='".url("curriculos/pdf/$curriculo->id")." target='_blank' class='btn btn-pn btn-ver btn-cor-neutra' data-id='$curriculo->id'><i class='fa fa-eye'></i></a><a href='".url("curriculos/$curriculo->id/edit")."' class='btn btn-pn btn-editar btn-cor-padrao' data-id='$curriculo->id'><i class='fa fa-edit'></i></a><a class='btn btn-pn btn-excluir btn-cor-perigo' data-toggle='modal' data-target='.modal-excluir-curriculo' data-id='$curriculo->id' data-nome='$curriculo->nome'><i class='fa fa-remove'></i></a>";

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
     * Tela de Criação de Relatórios
     */

    public function relatorios()
    {
        // Lista de áreas de atuação

        $areas = Area::all();

        return view('curriculos.relatorios', compact(['areas']));
    }

    /**
     * Imprimir relatório
     */

    public function imprimeRelatorio(Request $request)
    {
        // Validar

        $this->validate($request, [
            'ordem_relatorio' => 'required',
        ]);

        // Obter todos os participantes

        $query = Curriculo::with('areas');

        // Modifica o agrupamento e ordenação da query de acordo com os dados selecionados pelo usuário

        $cadastros = $this->modificaQuery($request, $query);

        // Obter todos os cabeçalhos selecionado

        $cabecalhos = $request->cabecalhos;

        // Titulo

        $titulo = [

            'geral'              => "POr Nome",
            'idade'              => "POR IDADE'",
            'sexo'               => "POR SEXO",
            'bairro'             => "Por Bairro",
            'formacao'           => "Por formação",
            'area_atuacao'       => "Por Área de Atuação",
            'indicacao_politica' => "Por Indicação Política",

        ];

        $nome_relatorio = $titulo[$request->ordem_relatorio];

        // Coleção que será enviada para o PDF

        $curriculos = $this->montaRelatorio($cadastros, $cabecalhos);

        // Gerar o PDF        

        // $pdf = PDF::loadView('curriculos.relatorio.geral', compact(['curriculos', 'cabecalhos', 'nome_relatorio']));

        // Enviar para o navegador

        // return $pdf->inline();
        return view ('curriculos.relatorio.geral', compact(['curriculos', 'cabecalhos', 'nome_relatorio']));
    }

    /**
     * Modificar o agrupamento e ordenação da query
     */

    protected function modificaQuery($request, $query)
    {
        // Verifica qual é a ordem do relatório

        // Geral, ordem alfabética dos nomes

        if($request->ordem_relatorio == 'geral')
            return $query->orderBy('nome', 'asc')->get();

        // Idade

        if($request->ordem_relatorio == 'idade')
            return $query->orderBy('nascimento')->get() ;        

        // Sexo

        if($request->ordem_relatorio == 'sexo')
            return $query->orderByRaw('sexo ASC, nome ASC')->get();

        // Bairro

        if($request->ordem_relatorio == 'bairro')
            return $query->orderBy('bairro', 'asc')->get();

        // Formação

        if($request->ordem_relatorio == 'formacao')
            return $query->orderBy('formacao', 'asc')->get();

        // Indicação Política

        if($request->ordem_relatorio == 'indicacao_politica')
            return $query->where("indicacao_politica", 1)->orderBy('nome')->get();
    }

    /**
     * Esta função chama a função montaLinhaDoRelatorio uma vez para cada
     * currículo enviado e retorna uma coleção contendo os dados de acordo
     * com os cabeçalhos escolhidos pelo usuário
     */

    protected function montaRelatorio($curriculos, $cabecalhos)
    {
        // Coleção que será enviada para o PDF

        $cadastros = collect();

        // Iterar pelos participantes e montar cada linha do relatório de acordo
        // com os cabeçalhos escolhidos

        foreach($curriculos as $curriculo)
        {
            $cadastros->push($this->montaLinhaDoRelatorio($curriculo, $cabecalhos));
        }

        return $cadastros;
    }

    /**
     * Essa função monta uma linha do relatório filtrando os dados do currículo
     * e fazendo ajustes de acordo com os cabeçalhos escolhidos
     */

    protected function montaLinhaDoRelatorio($curriculo, $cabecalhos)
    {
        $cadastro = [];

        // Nome
        if(array_key_exists('nome', $cabecalhos) !== false)
            $cadastro['nome'] = $curriculo->nome;

        // Idade
        if(array_key_exists('idade', $cabecalhos) !== false)
            $cadastro['idade'] = date('Y') - date('Y', strtotime($curriculo->nascimento)) ." Anos";

        // Sexo
        if(array_key_exists('sexo', $cabecalhos) !== false)
            $cadastro['sexo'] = $curriculo->sexo == "M" ? "Masculino" : "Feminino";

        // Nascimento
        if(array_key_exists('nascimento', $cabecalhos) !== false)
        {
            //Explodir a data de nascimento

            $data=explode("-", $curriculo->nascimento);

            //Inverter

            $data=array_reverse($data);

            // Implodir

            $data=implode("/", $data);

            // Atribuir

            $cadastro['nascimento'] = $data;
        }

        // Bairro
        if(array_key_exists('bairro', $cabecalhos) !== false)
            $cadastro['bairro'] = $curriculo->bairro;

        // Telefone Fixo
        if(array_key_exists('telefone_1', $cabecalhos) !== false)
            $cadastro['telefone_1'] = $curriculo->telefone_1;

        // Telefone Celular
        if(array_key_exists('telefone_2', $cabecalhos) !== false)
            $cadastro['telefone_2'] = $curriculo->telefone_2;

        // Endereço
        if(array_key_exists('endereco', $cabecalhos) !== false)
            $cadastro['endereco'] = $curriculo->rua." nº ".$curriculo->numero." - ".$curriculo->complemento;

        // CPF
        if(array_key_exists('cpf', $cabecalhos) !== false)
            $cadastro['cpf'] = $curriculo->cpf;

        // CTPS
        if(array_key_exists('ctps', $cabecalhos) !== false)
            $cadastro['ctps'] = $curriculo->ctps;

        // NIS
        if(array_key_exists('pis', $cabecalhos) !== false)
            $cadastro['pis'] = $curriculo->pis;

        // RG
        if(array_key_exists('rg', $cabecalhos) !== false)
            $cadastro['rg'] = $curriculo->rg;

        // Título Eleitoral
        if(array_key_exists('titulo', $cabecalhos) !== false)
            $cadastro['titulo'] = $curriculo->titulo;

        // Indicação Política
        if(array_key_exists('indicacao_politica', $cabecalhos) !== false)
            $cadastro['indicacao_politica'] = $curriculo->indicacao_politica ? "Sim" : "Não";

        // Formação
        if(array_key_exists('formacao', $cabecalhos) !== false)
            $cadastro['formacao'] = $curriculo->formacao;

        // CEP
        if(array_key_exists('cep', $cabecalhos) !== false)
            $cadastro['cep'] = $curriculo->cep;

        // Áreas de Atuação
        if(array_key_exists('areas', $cabecalhos) !== false)
        {
            $cadastro['areas'] = "";

            foreach($curriculo->areas as $area)
            {
                $cadastro['areas'] += $area->descricao;
            }
        }


        return $cadastro;
    }
}
