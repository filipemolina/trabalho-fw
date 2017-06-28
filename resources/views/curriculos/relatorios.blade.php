@extends("layouts.gentellela")

@section('titulo')

  Relatório

@endsection

@push("css")

  <link rel="stylesheet" href="{{ asset("vendors/iCheck/skins/flat/purple.css") }}">
 
@endpush

@push("scripts")

    @include('includes.relatorios.scripts')

@endpush

@section("conteudo")

    <div class="col-md-12 col-sm-12 col-xs-12">

      @if(count($errors) > 0)

        <div class="alert alert-roxo alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" >&times;</span></button>

          <strong>Atenção!</strong><br>

          <ul>

            @foreach($errors->all() as $erro)

              <li>{{ $erro }}</li>

            @endforeach

          </ul>

        </div>

      @endif

      <div class="x_title">
        <h2> Relatório</h2>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_panel modal-content">
        
        <div class="x_title"> Opções </div>
        
        <div class="x_content">

          <form target="_blank" action="{{ url('/curriculos/imprimerelatorios') }}" method="POST" class="form-horizontal" id="form-cadastro-usuario">

            {{ csrf_field() }}

            {{-- Campo Tipo do relatório--}}

            <div class="form-group">

              <label for="senha" class="col-sm-4 control-label">Ordem do Relatório</label>

              <div class="col-sm-4">

                 <select name="ordem_relatorio" class="form-control" id="ordem_relatorio">
                  <option value="">Selecione</option>
                  <option value="geral">Por Nome</option>
                  <option value="idade">Por Idade</option>
                  <option value="sexo">Por Sexo</option>
                  <option value="bairro">Por Bairro</option>
                  <option value="formacao">Por Formação</option>
                  <option value="area_atuacao">Por Área de Atuação</option>
                  <option value="indicacao_politica">Por Indicação Politica</option>
                </select>

              </div>

              <div class="col-sm-4">
                
                {{-- Select de áreas de atuação para montar o relatório. Só é visível caso o tipo de relatório seja por
                áres de atuação --}}

                <select style="display: none;" disabled class="form-control" name="area_atuacao" id="area_atuacao">
                    <option value="">Selecione</option>

                    @foreach($areas as $area)

                        <option value="{{ $area->id }}">{{ $area->descricao }}</option>

                    @endforeach

                </select>
              </div>
            </div>

            {{-- Campo Campo do Relatório --}}

            <div class="form-group">

                <label for="camporelatorio" class="col-sm-4 control-label">Campo do Relatório</label>

              <div class="checkbox" style="float: left;">
                <label>

                    <input value="Nome" name="cabecalhos[nome]" type="checkbox" checked="checked"> Nome

                </label> <br>

                <label>
                
                    <input value="Idade" name="cabecalhos[idade]" type="checkbox"> Idade

                </label> <br>

                <label>
                
                    <input value="Sexo" name="cabecalhos[sexo]" type="checkbox"> Sexo

                </label> <br>

                <label>
                
                    <input value="Data de Nascimento" name="cabecalhos[nascimento]" type="checkbox"> Data de Nascimento

                </label> <br>

                <label>
                
                    <input value="CPF" name="cabecalhos[cpf]" type="checkbox"> CPF

                </label> <br>

                <label>
                
                    <input value="CTPS" name="cabecalhos[ctps]" type="checkbox"> CTPS

                </label> <br>

                <label>
                
                    <input value="NIS" name="cabecalhos[pis]" type="checkbox"> NIS

                </label> <br>

                <label>
                
                    <input value="RG" name="cabecalhos[rg]" type="checkbox"> RG

                </label> <br>

                <label>
                
                    <input value="Telefone Fixo" name="cabecalhos[telefone_1]" type="checkbox"> Telefone Fixo

                </label> <br>

                <label>
                
                    <input value="Telefone Celular" name="cabecalhos[telefone_2]" type="checkbox"> Telefone Celular

                </label> <br>

                <label>
                
                    <input value="Endereço" name="cabecalhos[endereco]" type="checkbox"> Endereço

                </label> <br>

                <label>
                
                    <input value="CEP" name="cabecalhos[cep]" type="checkbox"> CEP

                </label> <br>

                <label>
                
                    <input value="Bairro" name="cabecalhos[bairro]" type="checkbox"> Bairro

                </label> <br>

                <label>
                
                    <input value="Formação" name="cabecalhos[formacao]" type="checkbox"> Formação

                </label> <br>

                <label>
                
                    <input value="Área de Atuação" name="cabecalhos[areas]" type="checkbox"> Área de Atuação

                </label> <br>

                <label>
                
                    <input value="Indicação Politica" name="cabecalhos[indicacao_politica]" type="checkbox"> Indicação Politica

                </label> <br>

                               
              </div>

            </div>

            <div class="form-group" style="text-align: center;">
                        <button type="submit" value="submit" data-toggle="tooltip" title="Imprimir relatório" class="btn btn-cor-padrao btn-lg-circulo"><i class="glyphicon glyphicon-print" style="margin-left: -2px;"></i></button>
            </div>

            
          </form>



        </div>
      </div>
    </div>


@endsection

@section("js")

<script>
  
  $(function(){

  // Selecionar campos do formulário de acordo com o tipo de formulário escolhido

  $("select#ordem_relatorio").change(function(){

    // Idade

    if($(this).val() == "idade"){ //campo que vai ser escolhido

      $("[name='cabecalhos\\[idade\\]']").prop('checked', true); //campo que vai ser selecionado

    } 

    // Sexo

    if($(this).val() == "sexo"){ 

      $("[name='cabecalhos\\[sexo\\]']").prop('checked', true); 

    }

    // Bairro

    if($(this).val() == "bairro"){ 

      $("[name='cabecalhos\\[bairro\\]']").prop('checked', true); 

    } 

    // Formação

    if($(this).val() == "formacao"){ 

      $("[name='cabecalhos\\[formacao\\]']").prop('checked', true); 
      

    } 

    // Áera de Atuação

    if($(this).val() == "area_atuacao"){ 

      $("[name='cabecalhos\\[areas\\]']").prop('checked', true); 
      

    } 

    // Indicação Politica

    if($(this).val() == "indicacao_politica"){ 

      $("[name='cabecalhos\\[indicacao_politica\\]']").prop('checked', true); 
      

    } 

  });

});

</script>




@endsection


