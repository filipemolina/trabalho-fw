<div class="row x_panel modal-content">
    <div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="dashboard_graph">
            <div class="row x_title">
                <div class="col-md-6">
                    <h3>Últimas Semanas <small></small></h3>
                </div>
                <div class="clearfix"></div>
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