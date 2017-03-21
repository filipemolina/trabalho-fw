<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;

class AreasController extends Controller
{

    protected $mensagens = [
        'required' => 'O campo :attribute é obrigatório'
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
        $areas = Area::all();

        return view('areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('areas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'descricao' => 'required',
        ], $this->mensagens);

        $area = new Area($request->all());

        $area->save();

        // Testar se a requisição foi enviada via AJAX
        // (No caso do cadastro de áreas de atuação feito através do botão na tela
        // de cadastro de currículos)

        if($request->ajax())

            // Neste caso, retornar o objeto que acabou de ser cadastrado para popular o select
            // na tela de cadastro

            return $area->toJson();

        else

            // Retornar para a tela de cadastro com uma mensagem de sucesso

            return redirect('areas/create')->with('mensagem', "Área de atuação cadastrada com sucesso");
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Obter a área de atuação à ser excluída

        $area = Area::find($id);

        // Deletar

        $area->delete();
    }
}
