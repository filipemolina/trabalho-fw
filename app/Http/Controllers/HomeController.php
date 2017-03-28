<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Curriculo;
use App\Area;


class HomeController extends Controller
{
    protected $mensagens = [
        'required' => 'O campo :attribute é obrigatório',
        'min' => 'O campo :attribute deve ter no mínimo 6 dígitos',
        'confirmed' => 'As senhas informadas não são iguais'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Variáveis enviadas para o Dashboard

        $resultados = [];

        // Contagem total de currículos

        $resultados['curriculos'] = DB::table('curriculos')->count();

        // Contagem de currículos por sexo

        $resultados['masculinos'] = DB::table('curriculos')->where('sexo', 'M')->count();
        $resultados['femininos'] = DB::table('curriculos')->where('sexo', 'F')->count();

        // Contagem de áreas de atuação

        $resultados['areas'] = DB::table('areas')->count();

        // Número de currículos já encaminhados

        $resultados['encaminhados'] = DB::table('curriculos')->where('encaminhado', true)->count();

        // Obter os dados adicionais necessários para se popular o Dashboard

        $resultados = $this->dashboard($resultados);

        $resultados['top_areas'] = $this->topAreas();

        return view('home', compact('resultados'));
    }

    public function configuracoes()
    {
        return view('home.configuracoes');
    }

    public function trocarSenha(Request $request)
    {
        // Obter o usuário logado

        $usuario = Auth::user();

        $this->validate($request, [
            'password' => 'required|min:6|confirmed'
        ], $this->mensagens);

        $usuario->password = Hash::make($request->input('password'));

        $usuario->save();

        return redirect('/configuracoes')->with('mensagem', 'Senha alterada com sucesso!');
    }

    // Popular o banco de dados com exemplos

    public function fabrica()
    {
        $fabricas = factory(Curriculo::class, 50)
            ->create()
            ->each(function($c){
                $c->areas()->save(Area::inRandomOrder()->first());
            });

        echo "<pre>";
        echo "<h1>Teste</h1>";
        print_r($fabricas);
        exit;
    }

    // Obter os dados das últimas 4 semanas para montar o gráfico e mostrar as taxas de aumento ou diminuição
    // de cadastros na tela principal do site.

    protected function dashboard($vetor)
    {
        //************************************************************************ Número de Currículos em geral

        // Currículos cadastrados na última semana

        $vetor['ultima-semana'] = DB::table('curriculos')->where('created_at', '>=', date('Y-m-d',strtotime('-1 week')))->count();

        $vetor['ultima-semana-2'] = DB::table('curriculos')->where([
            ['created_at', '<=', date('Y-m-d',strtotime('-1 week'))],
            ['created_at', '>=', date('Y-m-d',strtotime('-2 week'))]
        ])->count();

        // Vetor que guardará apenas os dados para o gráfico

        $vetor['datas'] = $this->semanasAnteriores(8);

        // Evitar a divisão por zero

        if($vetor['ultima-semana-2'] == 0)
            $vetor['porcentagem-total'] = 100;
        else
            $vetor['porcentagem-total'] = ceil($vetor['ultima-semana'] * 100 / $vetor['ultima-semana-2'] - 100);

        // Definir se o sinal deve ser positivo ou negativo

        if($vetor['porcentagem-total'] > 0)
            $vetor['sinal-porcentagem-total'] = 1;
        else
            $vetor['sinal-porcentagem-total'] = 0;

        //************************************************************************ Porcentagem de Currículos de Homens

        // Evitar a divisão por zero

        if($vetor['curriculos'] > 0)
            $vetor['porcentagem-m'] = ceil($vetor['masculinos'] / $vetor['curriculos'] * 100);
        else
            $vetor['porcentagem-m'] = 0;

        //************************************************************************ Porcentagem de Currículos de Mulheres

        // Evitar a divisão por zero

        if($vetor['curriculos'] > 0)
            $vetor['porcentagem-f'] = ceil($vetor['femininos'] / $vetor['curriculos'] * 100);
        else
            $vetor['porcentagem-f'] = 0;

        //************************************************************************ Porcentagem de Currículos Encaminhados

        if($vetor['curriculos'] > 0)
            $vetor['porcentagem-encaminhados'] = ceil($vetor['encaminhados'] / $vetor['curriculos'] * 100);
        else
            $vetor['porcentagem-encaminhados'] = 0;

        // Inverter as datas no vetor que será usado para gerar os gráficos, para que os resultados 
        // apareçam em ordem cronológica

        $vetor['datas'] = array_reverse($vetor['datas']);

        return $vetor;

    }

    // Retornar os dados referentes ao número de semanas anteriores desejado

    protected function semanasAnteriores($num)
    {
        // Vetor de resposta

        $resposta = [];

        // Realizar a operação o número de vezes especificado em '$num'

        for ($i=1; $i <= $num ; $i++) 
        {

            $proxima = $i - 1;
            
            $resposta[] = [

                'qtd' => DB::table('curriculos')->where([
                    ['created_at', '>=', date('Y-m-d H:i:s',strtotime("-$i week"))],
                    ['created_at', '<=', date('Y-m-d H:i:s',strtotime("-$proxima week"))],
                ])->count(),
                // 'qtd' => rand(0, 50),
                'dia' => date('d', strtotime("-$i week")),
                'mes' => date('m', strtotime("-$i week")),
                'ano' => date('Y', strtotime("-$i week"))

            ];

        }

        return $resposta;
    }

    // Retornar as 4 áreas de atuação com mais currículos, e a porcentagem de currículos em cada
    // uma com relação à quantidade total de currículos

    protected function topAreas()
    {
        // Fazer uma query na tabela pivô "area_curriculo" para selecionar as 4 áreas de atuação
        // mais procuradas

        $top_areas = DB::table('area_curriculo')
                        ->select(DB::raw('area_id, COUNT(area_id) as count'))
                        ->groupBy('area_id')
                        ->orderBy(DB::raw('COUNT(area_id)'), "DESC")
                        ->limit('4')
                        ->get();

        // Número total de currículos

        $num_curriculos = Curriculo::count();


        // Formar o vetor que será retornado contendo as descrições das primeiras áreas de atuação
        // e a porcentagem de ocorrência

        $resposta = [];

        // Evitar a divisão por zero

        if($num_curriculos > 0)
        {
            // Iterar pelas principais áreas e popular o vetor com as informações

            foreach($top_areas as $top_area)
            {
                $area = Area::find($top_area->area_id);

                $resposta[] = [
                    'descricao' => $area->descricao,
                    'porcentagem' => $top_area->count * 100 / $num_curriculos
                ];
            }

        }
        else
        {
            // Caso contrário, preencher apenas com uma entrada vazia

            $resposta[] = [
                'descricao' => 'Nenhum Currículo Cadastrado',
                'porcentagem' => 0
            ];
        }

        return $resposta;

    }
}
