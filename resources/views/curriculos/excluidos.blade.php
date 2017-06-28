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

  <button class="btn btn-info btn-cadastrar-curriculo btn-cor-padrao modal-content" onclick="location.href='{{ url('curriculos/') }}'"> <i class="fa fa-id-card"></i> Lista de Currículos Ativos</button>

@endsection

@section('conteudo')

<div class="row">
    
<div class="col-md-12 col-sm-12 col-xs-12">

	<div class="row curriculo-index">
		
		<div class="col-md-12 col-sm-12 col-xs-12">
          	<div class="x_panel modal-content">
	            <div class="x_title">
	              	<h2>Currículos Excluídos <small>Utilize os comandos da tabela para reordenar e pesquisar</small></h2>
	              	<div class="clearfix"></div>
	            </div>
            	<div class="x_content">

                  	<table id="datatable" class="table table-striped table-bordered">
                      	<thead>
                        	<tr>
                          		<th>Nome</th>
                          		<th>Idade</th>
                              <th>Área de Atuação</th>
                              <th>Indicação</th>
                              <th>Quem Excluiu?</th>
                              <th style="min-width: 65px;">Ações</th>
                        	</tr>
                      	</thead>


                      	<tbody>

                          {{-- Iterar pelos currículos para mostrar na tabela --}}

                          @foreach($excluidos as $curriculo)

                          	<tr>
                            		<td class="bife">{{ $curriculo->nome }}</td>
                            		<td>{{ $idades[$curriculo->id] }}</td>
                                <td></td>
                            		<td>{{ $curriculo->indicacao_politica }}</td>
                                <td>{{ $curriculo->quem_deletou->name }}</td>
                                <td>
                                  
                                  {{-- Botão de visualizar, envia uma requisição GET com o id do currículo --}}

                                  <button class="btn btn-success btn-restaurar" data-id="{{ $curriculo->id }}"><i class="fa fa-reply-all"></i></button>

                                  <form style="display: none;" id="{{ $curriculo->id }}" action="{{ url("curriculos/$curriculo->id/restaurar") }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $curriculo->id }}" name="id">
                                  </form>
                                    
                                  {{-- Botão de Exclusão --}}

                                  <a class="btn btn-danger btn-excluir" data-toggle="modal" data-target=".modal-excluir-curriculo" data-id="{{ $curriculo->id }}" data-nome="{{ $curriculo->nome }}"><i class="fa fa-remove"></i></a>

                                </td>
                          	</tr>

                          @endforeach

                        </tbody>
                    </table>              
            	</div>
          	</div>
        </div>
	</div>

  {{-- Modal --}}

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

    {{-- /Modal --}}

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
      
      $(function(){

        // Botão Restaurar
        // Submeter o formulário logo abaixo do botão via POST

        $("button.btn-restaurar").click(function(){

          // Obter o id do currículo à ser restaurado

          var id = $(this).data('id');

          $("form#"+id).submit();

        });

        // Ativar o DataTables

        var table = $('#datatable').DataTable({
          'language' : {
            'url' : '{{ asset('/js/portugues.json') }}'
          }
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

        $('.btn-excluir').click(function(){

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

          $.post("{{ url('curriculos-excluidos/') }}/"+id, {
            _token  : "{{ csrf_token() }}",
            _method : 'DELETE',
            id : id
          }, function(data){

            window.location = "{{ url('curriculos-excluidos/') }}";

          });

        });

      });
      
    </script>

    @include("includes.curriculos.excluidos.scripts")

@endsection