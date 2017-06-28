@extends('layouts.gentellela')

@section('title')

    Dashboard

@endsection

@section('css')



@endsection

@section('menu-superior')

    <button class="btn-cadastrar-curriculo btn btn-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fa fa-close"></i> Sair </button>
    <button class="btn-cadastrar-curriculo btn btn-info" onclick="window.location='{{ url('/configuracoes') }}'"> <i class="fa fa-key"></i> Alterar Senha </button>
    <button class="btn-cadastrar-curriculo btn btn-info" onclick="window.location='{{ url('areas/create') }}'"> <i class="fa fa-crosshairs"></i> Cadastrar Área de Atuação </button>
    <button class="btn-cadastrar-curriculo btn btn-info" onclick="window.location='{{ url('curriculos/create') }}'"> <i class="fa fa-id-card"></i> Cadastrar Currículo </button>

@endsection

@section('conteudo')

  
<!-- top tiles -->
<div class="row tile_count">
    
    {{-- Total de Currículos Cadastrados --}}

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Currículos</span>
        <div class="count">{{ $resultados['curriculos'] }}</div>

        {{-- Testar se o sinal deve ser positivo ou negativo --}}

        {{-- @if ($resultados['sinal-porcentagem-total'])

            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>{{ $resultados['porcentagem-total'] }}% </i> </span>

        @else

            <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>{{ $resultados['porcentagem-total'] }}% </i>
            </span>
        @endif --}}
        <span class="count_bottom">Total de cadastros.</span>
    </div>
    
    {{-- Total de Mulheres --}}

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-venus"></i> Total de Mulheres</span>
        <div class="count">{{ $resultados['femininos'] }}</div>
        <span class="count_bottom"><i class="green">{{ $resultados['porcentagem-f'] }}% </i> do total</span>

    </div>

    {{-- Total de Homens --}}

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-mars"></i> Total de Homens</span>
        <div class="count">{{ $resultados['masculinos'] }}</div>
        <span class="count_bottom"><i class="green">{{ $resultados['porcentagem-m'] }}% </i> do total</span>
    </div>
    
    {{-- Total de Áreas de Atuação --}}

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-suitcase"></i> Áreas de Atuação</span>
        <div class="count">{{ $resultados['areas'] }}</div>
        <span class="count_bottom">Cadastradas no total.</span>
    </div>

    {{-- Currículos Cadastrados nesta semana --}}

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Nesta Semana</span>
        <div class="count">{{ $resultados['ultima-semana'] }}</div>
        <span class="count_bottom">Currículos cadastrados.</span>
    </div>
</div>
<!-- /top tiles -->
{{-- <br>

<div class="row">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel title">
            
            <div class="x_title">
                <h2>Ações Principais</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <button class="btn btn-info"> <i class="fa fa-id-card"></i> Cadastrar Currículo </button>
                <button class="btn btn-info"> <i class="fa fa-crosshairs"></i> Cadastrar Área de Atuação </button>
                <button class="btn btn-info"> <i class="fa fa-key"></i> Alterar Senha </button>
                <button class="btn btn-danger"> <i class="fa fa-close"></i> Sair </button>
            </div>

        </div>
    </div>

</div>

<br> --}}

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph">

            <div class="row x_title">
                <div class="col-md-6">
                    <h3>Últimas Semanas <small></small></h3>
                </div>
                
                {{-- Calendário para selecionar a data do gráfico --}}

                {{-- <div class="col-md-6">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                </div> --}}
            </div>

            <div class="col-md-9 col-sm-9 col-xs-12">
                <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
                <div style="width: 100%;">
                    <div id="canvas_dahs" class="demo-placeholder" style="width: 100%; height:270px;"></div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 bg-white">
                <div class="x_title">
                    <h2>Áreas Mais Procuradas</h2>
                    <div class="clearfix"></div>
                </div>

                @foreach($resultados['top_areas'] as $top_area)

                    <div class="col-md-12 col-sm-12 col-xs-6">
                        <div>
                            <p>{{ $top_area['descricao'] }}</p>
                            <div class="">
                                <div class="progress progress_sm" style="width: 76%;">
                                    <div class="progress-bar bg-padrao" role="progressbar" data-transitiongoal="{{ $top_area['porcentagem'] }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

</div>
<br>
<!-- /page content -->

@endsection

@section('js')

     <!-- Chart.js -->
    <script src="{{ asset('vendors/Chart.js/dist/Chart.min.js') }}"></script>
    <!-- gauge.js -->
    <script src="{{ asset('vendors/gauge.js/dist/gauge.min.js') }}"></script>
    <!-- Skycons -->
    <script src="{{ asset('vendors/skycons/skycons.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.resize.js') }}"></script>
    <!-- Flot plugins -->
    <script src="{{ asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('vendors/flot.curvedlines/curvedLines.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('vendors/DateJS/build/date.js') }}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>


<!-- Flot -->
    <script>
      $(document).ready(function() {
        var data1 = [

            @foreach($resultados['datas'] as $data)

                [gd({{ $data['ano'] }}, {{ $data['mes'] }}, {{ $data['dia'] }}), {{ $data['qtd'] }}],

            @endforeach

        ];

        $("#canvas_dahs").length && $.plot($("#canvas_dahs"), [
          data1,
        ], {
          series: {
            bars: {
              show: false,
              // fill: true
            },
            splines: {
              show: true,
              tension: 0,
              lineWidth: 1,
              fill: 0.4
            },
            points: {
              radius: 0,
              show: true
            },
            shadowSize: 2
          },
          bars: {
            align: 'center',
            barWidth: 60 * 60 * 150000
          },
          grid: {
            verticalLines: true,
            hoverable: true,
            clickable: true,
            tickColor: "#d5d5d5",
            borderWidth: 1,
            color: '#fff',
          },
          colors: ["rgba(62, 39, 107, 0.38)"],
          xaxis: {
            tickColor: "rgba(51, 51, 51, 0.06)",
            timeformat: '%d/%m/%Y',
            mode: "time",
            tickSize: [7, "day"],
            tickLength: 5,
            tickMargin: 10000,
            axisLabel: "Semanas",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 0
          },
          yaxis: {
            ticks: 8,
            tickColor: "rgba(51, 51, 51, 0.06)",
          },
          tooltip: false
        });

        function gd(year, month, day) {
          return new Date(year, month - 1, day).getTime();
        }
      });
    </script>
    <!-- /Flot -->

@endsection