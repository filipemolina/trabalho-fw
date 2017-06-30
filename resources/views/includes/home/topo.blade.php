<!-- top tiles -->
<div class="tile_count">
    
    {{-- Total de Currículos Cadastrados --}}

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-id-card"></i> Currículos</span>
        <div class="count">{{ $resultados['curriculos'] }}</div>
        <span class="count_bottom">Cadastros no total.</span>
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

    <div style="clear: both;"></div>
</div>
<!-- /top tiles -->