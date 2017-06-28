@extends('layouts.gentellela')

{{-- CSS Adicional Necessário --}}

@section('css')

	<!-- Datatables -->

    <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

@endsection

@section('menu-superior')

  <button class="btn btn-info btn-cadastrar-curriculo btn-cor-padrao modal-content" onclick="location.href='{{ url('curriculos/create') }}'"> <i class="fa fa-id-card"></i> Cadastrar Currículo</button>

@endsection

@section('conteudo')

  <div class="row">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel modal-content" style="height: auto;">
        <div class="x_title">
          <h2>Busca Avançada</h2>
          <ul class="nav navbar-right panel_toolbox" style="min-width: 0px;">
            <li><a class="limpar1" data-toggle="tooltip" title="Limpar campos"><i class="fa fa-remove btn btn-circulo-pn btn-cor-perigo"></i></a></li>
            <li><a class="collapse-link" data-toggle="tooltip" title="Reduzir / Expandir"><i class="fa fa-chevron-up btn btn-circulo-pn btn-cor-padrao"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content" style="display: none;">

          <div class="row">

            <div class="col-md-3 form-group">
              <label for="nome">
                  Nome
                  <div class="input-group has-clear">
                      <input type="text" id="nome" class="form-control input-sm">

                      <a style="margin-right: 0; margin-bottom: 3px;" class=" span-clear"><i class="btn btn-circulo-pn btn-cor-perigo glyphicon glyphicon-remove span-alinhar" style="margin-top: -10px;"></i></a>

                  </div>
              </label>
            </div>

            <div class="col-md-3">
                <label for="indicacao">
                    Bairro

                    <div class="input-group has-clear">
                        <input type="text" id="bairro" class="form-control input-sm" />
                        <a style="margin-right: 0; margin-bottom: 3px;" class=" span-clear"><i class="btn btn-circulo-pn btn-cor-perigo glyphicon glyphicon-remove span-alinhar" style="margin-top: -10px;"></i></a>
                        
                    </div>
                </label>
            </div>

            <div class="col-md-3">
              <label for="min">
                Idade Mínima:
                
                <div class="input-group has-clear">
                  <input type="number" id="min" class="form-control input-sm" />
                  <a style="margin-right: 0; margin-bottom: 3px;" class=" span-clear"><i class="btn btn-circulo-pn btn-cor-perigo glyphicon glyphicon-remove span-alinhar" style="margin-top: -10px;"></i></a>

                </div>
              </label>  
            </div>

            <div class="col-md-3">
              <label for="min">
                  Idade Máxima:
                  <div class="input-group has-clear">

                      <input type="number" id="max" class="form-control input-sm" /></label>
                      <a style="margin-right: 0; margin-bottom: 3px;" class=" span-clear"><i class="btn btn-circulo-pn btn-cor-perigo glyphicon glyphicon-remove span-alinhar" style="margin-top: -10px;"></i></a>

                  </div>
              </label>
            </div>

          </div>

          <div class="row">
            
            <div class="col-md-3">
              <label for="sexo">

                Sexo

                <div class="input-group has-clear">

                  <select type="text" id="sexo" class="select2_group form-control input-sm">

                    <option value=""> Selecione </option>
                    <option> Masculino </option>
                    <option> Feminino </option>
                    <option> Ambos </option>
                    
                  </select>

                  <a style="margin-right: 0; margin-bottom: 3px;" class=" span-clear"><i class="btn btn-circulo-pn btn-cor-perigo glyphicon glyphicon-remove span-alinhar" style="margin-top: -10px;"></i></a>

                </div>
              </label> 
            </div>

            <div class="col-md-3">

              <label for="formacao">

                  Formação

                  <div class="input-group has-clear">
                      <select id="formacao" name="formacao" class="select2_group form-control input-sm">
                          <option value="">Selecione...</option>
                          <option value="Fundamental" @if (old('formacao') == 'Fundamental') selecte="selected" @endif>Fundamental</option>
                          <option value="Médio" @if (old('formacao') == 'Médio') selecte="selected" @endif>Médio</option>
                          <option value="Superior" @if (old('formacao') == 'Superior') selecte="selected" @endif>Superior</option>
                      </select>
                      <a style="margin-right: 0; margin-bottom: 3px;" class=" span-clear"><i class="btn btn-circulo-pn btn-cor-perigo glyphicon glyphicon-remove span-alinhar" style="margin-top: -10px;"></i></a>

                  </div>
              </label>  
            </div>

            <div class="col-md-3">
              <label for="atuacao">

                Área de atuação

                <div class="input-group has-clear">
                    <select id="area" name="area[]" class="select2_group form-control input-sm">
                                
                                <option value="">Selecione...</option>

                                  {{-- Iterar pelar áreas de atuação --}}

                                {{-- @foreach($areas as $area)

                                    <option value="{{ $area->id }}" @if (old('area') == $area->id) selected="selected" @endif>{{ $area->descricao }}</option>

                                @endforeach --}}

                    </select>
                    <a style="margin-right: 0; margin-bottom: 3px;" class=" span-clear"><i class="btn btn-circulo-pn btn-cor-perigo glyphicon glyphicon-remove span-alinhar" style="margin-top: -10px;"></i></a>

                </div>
              </label>
            </div>

            <div class="col-md-3">
                <label for="indicacao">
                    Indicação

                    <div class="input-group has-clear">

                  <select type="text" id="indicacao" class="select2_group form-control input-sm">

                    <option value=""> Selecione... </option>
                    <option> Sim </option>
                    <option> Não </option>
                    
                  </select>

                  <a style="margin-right: 0; margin-bottom: 3px;" class=" span-clear"><i class="btn btn-circulo-pn btn-cor-perigo glyphicon glyphicon-remove span-alinhar" style="margin-top: -10px;"></i></a>

                </div>
                </label>
            </div>
          </div>
          <div class="clearfix"></div>
      </div>
    </div>

  </div>

	<div class="row curriculo-index">
		
		<div class="col-md-12 col-sm-12 col-xs-12">
          	<div class="x_panel">
	            <div class="x_title">
	              	<h2>Currículos <small>Utilize os comandos da tabela para reordenar e pesquisar</small></h2>
	              	<div class="clearfix"></div>
	            </div>
            	<div class="x_content">

                  	<table id="datatable" class="table table-striped table-bordered">
                      	<thead>
                        	<tr>
                          		<th style="max-width: 265px;">Nome</th>
                          		<th>Idade</th>
                              <th>Sexo</th>
                          		<th>Bairro</th>
                          		<th>Formação</th>
                              <th>Área de Atuação</th>
                              <th>Indicação</th>
                              <th style="max-width: 80px;">Encaminhar?</th>
                              <th style="min-width: 65px;">Ações</th>
                        	</tr>
                      	</thead>
                        <tbody>

                          {{-- Tabela preenchida com dataTables Server Side --}}

                        </tbody>
                    </table>

                    {{-- Botão de Encaminhar Currículos --}}

                    <div class="btn-encaminhar">
                      
                      <button class="btn btn-info btn-encaminhar btn-cor-padrao disabled" data-toggle="modal" data-target=".modal-encaminhar"><i class="fa fa-share"></i> Encaminhar Currículo</button>
                      
                      {{-- Botão para selecionar todos currículos --}}
                      
                      <button class="btn btn-info btn-selecionar btn-cor-padrao"><i class="fa fa-check"></i> <span class="acao">Marcar</span> Todos</button>

                    </div>

            	</div>
          	</div>
        </div>
	</div>

  {{-- Modal Excluir --}}

    <div class="modal fade bs-example-modal-sm modal-excluir-curriculo" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Deseja realmente excluir o currículo de <span class="nome"></span> ?</h4>
          </div>
          <div class="modal-body">
            <p>O currículo excluído não poderá ser recuperado posteriormente.</p>
          </div>
          <div class="modal-footer">
            <input type="hidden" value="" id="curriculo_id">
            <button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-danger btn-confirmar-modal">Excluir</button>
          </div>

        </div>
      </div>
    </div>

    {{-- /Modal Excluir --}}

    {{-- Modal Encaminhar --}}

      <div class="modal fade bs-example-modal-sm modal-encaminhar" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Encaminhar Currículos:</h4>
          </div>
          <div class="modal-body">

          <div class="alert alert-success">
            
            <ul id="lista-curriculos">

            </ul>

          </div>

            <div class="form-group">
              <label for="empresa" class="col-md-3">Empresa</label>
              <div class="col-md-9">
                <input type="text" class="form-control col-md-12" name="empresa" id="empresa">
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          
          <div class="modal-footer">

            {{-- Nesta div serão inseridos vários inputs do tipo hidden, um para cada currículo encaminhado --}}

            <div class="curriculos"></div>

            <button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-success btn-confirmar-encaminhamento">Encaminhar</button>
          </div>

        </div>
      </div>
    </div>

    {{-- /Modal Encaminhar --}}

@endsection

@section('js')

	<!-- Datatables -->
    <script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/pdfmake/build/vfs_fonts.js') }}"></script>


    <script>

      var todos_selecionados = false;
      
      $(function(){

        // Ativar o DataTables

        var table = $('#datatable').DataTable({
          'language' : {
            'url' : '{{ asset('/js/portugues.json') }}'
          },
          processing: true,
          serverSide: true,
          ajax      : "{{ url('/curriculos/tabela') }}",
          columns   : [

            { data : 'nome',       name : 'nome' },
            { data : 'idade',      name : 'idade' },
            { data : 'sexo',       name : 'sexo' },
            { data : 'bairro',     name : 'bairro' },
            { data : 'formacao',   name : 'formacao' },
            { data : 'area',       name : 'area' },
            { data : 'indicacao',  name : 'indicacao' },
            { data : 'encaminhar', name : 'encaminhar' },
            { data : 'acoes',      name : 'acoes' },

          ],
          stateSave: true,
          stateDuration: -1,
        });

        /* Função para incluir a busca pelos campos de Idade Mínima e Máxima */
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = parseInt( $('#min').val(), 10 );
                var max = parseInt( $('#max').val(), 10 );
                var age = parseFloat( data[1] ) || 0; // use data for the age column
         
                if ( ( isNaN( min ) && isNaN( max ) ) ||
                     ( isNaN( min ) && age <= max ) ||
                     ( min <= age   && isNaN( max ) ) ||
                     ( min <= age   && age <= max ) )
                {
                    return true;
                }
                return false;
            }
        );

        // Event Listener para a função customizada criada acima
        $('#min, #max').keyup( function() {
            table.draw();
        } );

        // Popular o modal com as informações do currículo à ser excluído

        $('body').on('click', '.btn-excluir', function(){

          var nome = $(this).data('nome');

          // Definir o valor do campo hidden "curriculo_id" que será usando quando o usuário
          // confirmar a exclusão no modal

          $("#curriculo_id").val($(this).data('id'));

          $('.modal-content span.nome').html(nome);

        });

        // Excluir o currículo quando o usuário confirmar no modal

        $('.btn-confirmar-modal').click(function(){

          var id = $("#curriculo_id").val();

          // Enviar a requisição DELETE para o Laravel, caso positivo

          $.post("{{ url('curriculos/') }}/"+id, {
            _token  : "{{ csrf_token() }}",
            _method : 'DELETE',
            id : id
          }, function(data){

            // window.location = "{{ url('curriculos/') }}";

            $("a.btn-excluir[data-id="+id+"]").parents('tr').remove();

            $(".modal-excluir-curriculo").modal('hide');

          });

        });

        // Evitar que o botão "Encaminhar currículos" continue abrindo o modal
        // mesmo quando estiver desabilitado

        $("button.btn-encaminhar").click(function(e){

          if($(this).hasClass('disabled'))
            e.stopPropagation();

        });

        // Popular o Modal com as informações do currículo à ser ENCAMINHADO

        // Esse evento é disparado pela biblioteca iCheck, inputs com iCheck não
        // disparam eventos padrão (infelizmente)

        $('input.chk-encaminhar').on('ifChanged',function(){

            // Toda vez que um checkbox for clicado, iterar por todos os checkboxes exibidos,
            // apagar a lista de currículos no modal e então incluir apenas os nomes dos currículos
            // selecionados

            // Apagar todas as LI's

            $("ul#lista-curriculos").empty();

            // Apagar todos os campos hidden

            $("div.modal-footer .curriculos").empty();

            // Iterar pelos checkboxes clicados

            $("input.chk-encaminhar:checked").each(function(index, element){

                var nome = $(element).data('nome');
                var id = $(element).data('id');

                //Adicionar o nome à lista

                $("ul#lista-curriculos").append($('<li>').html(nome));

                // Adicionar o ID aos campos hidden

                $("<input>").attr('type', 'hidden').attr('name', 'ids[]').val(id).appendTo('div.modal-footer .curriculos');

            });

            // Abilitar ou desabilitar o botão de encaminhar

            if(!$("input.chk-encaminhar:checked").length)

              $("button.btn-encaminhar").addClass('disabled');

            else

              $("button.btn-encaminhar").removeClass('disabled');

        });

        // Enviar a requsição POST para /curriculos/encaminhar quando o botão do modal for clicado

        $("button.btn-confirmar-encaminhamento").click(function(){

            var ids = [];
            var empresa = $("input#empresa").val();

            $("input.chk-encaminhar:checked").each(function(index, value){

                ids.push($(value).data('id'));

            });

            // Enviar a requisição

            $.post('{{ url('/curriculos/encaminhar') }}', {
              _token  : "{{ csrf_token() }}",
              ids     : ids,
              empresa : empresa,
            }, function(data){

              $(".modal-encaminhar").modal('toggle');
              $("input#empresa").val("");

            })

        });

        // Selecionar ou apagar todos os checkboxes

        $("button.btn-selecionar").click(function(){

            if(!todos_selecionados){

              $("input.chk-encaminhar").iCheck('check');

              $("button.btn-selecionar i").removeClass('fa-check').addClass('fa-times');

              $("button.btn-selecionar .acao").html("Desmarcar");

              todos_selecionados = true;

            }
            else
            {

              $("input.chk-encaminhar").iCheck('uncheck');

              $("button.btn-selecionar i").removeClass('fa-times').addClass('fa-check');

              $("button.btn-selecionar .acao").html("Marcar");

              todos_selecionados = false;

            }

              

        });

      });
      
      // Limpar campo
      $('.has-clear input, .has-clear select').on('change propertychange', function() {
          var $this = $(this);
          var visible = Boolean($this.val());
          $this.siblings('.span-clear').toggleClass('hidden', !visible);
      }).trigger('propertychange');

      $('.span-clear').click(function() {
          $(this).siblings('input, select').val('')
          .trigger('propertychange').focus();
      });

      // Limpar todos os campos
      $(document).on("click", ".limpar1", function(e){

          e.preventDefault();

          $(this).parent().parent().parent().parent().find("input, select").val('');

      });
      
    </script>

@endsection