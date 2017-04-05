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

  <button class="btn btn-info btn-cadastrar-curriculo" onclick="location.href='{{ url('curriculos/create') }}'"> <i class="fa fa-id-card"></i> Cadastrar Currículo</button>

@endsection

@section('conteudo')

	<div class="row curriculo-index">
		
		<div class="col-md-12 col-sm-12 col-xs-12">
          	<div class="x_panel">
	            <div class="x_title">
	              	<h2>Currículos Encaminhados<small>Utilize os comandos da tabela para reordenar e pesquisar</small></h2>
	              	<div class="clearfix"></div>
	            </div>
            	<div class="x_content">

                  	<table id="datatable" class="table table-striped table-bordered">
                      	<thead>
                        	<tr>
                          		<th>Nome</th>
                          		<th>Bairro</th>
                          		<th>Formação</th>
                              <th>Indicação</th>
                              <th>Empresa</th>
                              <th style="min-width: 65px;">Ações</th>
                        	</tr>
                      	</thead>


                      	<tbody>

                          {{-- Iterar pelos currículos para mostrar na tabela --}}

                          @foreach($curriculos as $curriculo)

                          	<tr>
                            		<td class="bife">{{ $curriculo->nome }}</td>
                            		<td>{{ $curriculo->bairro }}</td>
                            		<td>{{ $curriculo->formacao }}</td>
                            		<td>@if($curriculo->indicacao_politica) Sim @else Não @endif</td>
                                <td>{{ $curriculo->empresa->descricao }}</td>
                                <td>
                                  
                                  {{-- Botão de visualizar, envia uma requisição GET com o id do currículo --}}

                                  <a href="{{ url("curriculos/pdf/$curriculo->id") }}" target="_blank" class="btn btn-success btn-ver"   data-id="{{ $curriculo->id }}"><i class="fa fa-eye"></i></a>
                                  
                                  {{-- Botão Editar, leva para a tela de edição do currículo --}}

                                  <a href="{{ url("curriculos/$curriculo->id/edit") }}" class="btn btn-info btn-editar" data-id="{{ $curriculo->id }}"><i class="fa fa-edit"></i></a>
                                    
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

  {{-- Modal Excluir --}}

    <div class="modal fade bs-example-modal-sm modal-excluir-curriculo" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Deseja realmente retornar o currículo de <span class="nome"></span> ?</h4>
          </div>
          <div class="modal-body">
            <p>O currículo retornará para a lista de curriculos disponíveis.</p>
          </div>
          <div class="modal-footer">
            <input type="hidden" value="" id="curriculo_id">
            <button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-danger btn-confirmar-modal">Retornar</button>
          </div>

        </div>
      </div>
    </div>

    {{-- /Modal Excluir --}}

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

        // Popular o modal com as informações do currículo à ser retornado

        $('.btn-excluir').click(function(){

          var nome = $(this).data('nome');

          // Definir o valor do campo hidden "curriculo_id" que será usando quando o usuário
          // confirmar o retorno do currículo no modal

          $("#curriculo_id").val($(this).data('id'));

          $('.modal-content span.nome').html(nome);

        });

        // Retornar o currículo quando o usuário confirmar no modal

        $('.btn-confirmar-modal').click(function(){

          var id = $("#curriculo_id").val();

          // Enviar a requisição para o Laravel

          $.post("{{ url('curriculos/retornar') }}/"+id, {
            _token  : "{{ csrf_token() }}",
            id : id
          }, function(data){

            window.location = "{{ url('curriculos-encaminhados/') }}";

          });

        });

      });
      
    </script>

@endsection