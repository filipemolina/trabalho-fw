<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Curriculo;
use App\Area;

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
        $idades = [];

        // Criar um vetor associativo no formato [ 'id do curriculo' => 'idade']

        foreach($curriculos as $curriculo)
        {
            $nascimento = date('Y', strtotime(implode(array_reverse(explode('/',$curriculo->nascimento)))));
            $idade = date('Y') - $nascimento;

            $idades[$curriculo->id] = $idade;
        }

        return view('curriculos.index', compact(['curriculos', 'idades']));
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
            'cpf' => 'required|unique:curriculos|cpf',
            'rua' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'titulo' => 'required|documento',
            'area' => 'required',
            'sexo' => 'required',
            'rg' => 'documento',
            'pis' => 'documento',
            'ctps' => 'documento'
        ], $this->mensagens);

        $curriculo = new Curriculo($request->all());

        // Relacionar à área de atuação

        $curriculo->save();

        $curriculo->areas()->attach($request->input('area'));

        // Retornar para o formulário de cadastro com mensagem de sucesso

        return redirect('curriculos/create')->with('mensagem', 'Currículo cadastrado com sucesso!');
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
            'cpf' => 'required',
            'rua' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'titulo' => 'required',
            'area' => 'required',
            'sexo' => 'required',
        ], $this->mensagens);

        $curriculo->update($request->all());

        $curriculo->areas()->sync([$request->input('area')]);

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

        // Destruí-lo

        $curriculo->delete();
    }

    public function pdf($id)
    {
        $curriculo = Curriculo::find($id);

        $pdf = PDF::loadView('pdf.curriculo', compact('curriculo'));

        return $pdf->stream();
    }
}
