@extends('layouts.gentellela')

@section('title')

	Lista de Áreas de Atuação

@endsection

@section('css')

	<!-- Datatables -->
    <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

@endsection

@section('menu-superior')

  <button class="btn btn-info btn-cadastrar-curriculo" onclick="location.href='{{ url('areas/create') }}'"> <i class="fa fa-crosshairs"></i> Cadastrar Área de Atuação</button>

@endsection

@section('conteudo')

	<div class="row curriculo-index">
		
		<div class="col-md-12 col-sm-12 col-xs-12">
          	<div class="x_panel">
	            <div class="x_title">
	              	<h2>Áreas de Atuação <small>Utilize os comandos da tabela para reordenar e pesquisar</small></h2>
	              	<div class="clearfix"></div>
	            </div>
            	<div class="x_content">

            		<table id="datatable" class="table table-striped table-bordered">
                      	<thead>
                        	<tr>
                          		<th>ID</th>
                          		<th>Descrição</th>
                              <th>Ações</th>
                        	</tr>
                      	</thead>


                      	<tbody>

                          {{-- Iterar pelos currículos para mostrar na tabela --}}

                          @foreach($areas as $area)

                          	<tr>
                          		<td>{{ $area->id }}</td>
                          		<td>{{ $area->descricao }}</td>
                              <td>
                                  {{-- Botão de Exclusão --}}

                                  <a class="btn btn-danger btn-excluir" data-toggle="modal" data-target=".modal-excluir-area" data-id="{{ $area->id }}" data-descricao="{{ $area->descricao }}"><i class="fa fa-remove"></i></a>
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

    <div class="modal fade bs-example-modal-sm modal-excluir-area" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Deseja excluir "<span class="descricao"></span>" ?</h4>
          </div>
          <div class="modal-body">
            <p>A área de atuação excluída não poderá ser recuperado posteriormente.</p>
          </div>
          <div class="modal-footer">
            <input type="hidden" value="" id="area_id">
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

        // Ativar o DataTables

        $('#datatable').DataTable({
          'language' : {
            'url' : '{{ asset('/js/portugues.json') }}'
          }
        });

        // Popular o modal com as informações da área de atuação à ser excluída

        $(".btn-excluir").click(function(){

          var descricao = $(this).data('descricao');

          var id = $(this).data('id');

          // Atribuir o valor do ID ao campo hidden "area_id" para ser excluído posteriormente

          $("#area_id").val(id);

          $(".modal-content span.descricao").html(descricao);

        });

        // Excluir a área de atuação após a confirmação no modal

        $(".btn-confirmar-modal").click(function(){

          var id = $("#area_id").val();

          $.post('{{ url('areas/') }}/'+id, {

            _token : '{{ csrf_token() }}',
            _method : 'DELETE',
            id : id

          }, function(data){

            window.location = '/areas';

          });

        });


     });
      
    </script>

@endsection
