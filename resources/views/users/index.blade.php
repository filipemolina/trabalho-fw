@extends('layouts.gentellela')

@section('title')

	Lista de Usuários

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

  <button class="btn btn-info btn-cadastrar-curriculo btn-cor-padrao modal-content" onclick="location.href='{{ url('usuarios/create') }}'"> <i class="fa fa-user-circle"></i> Cadastrar Usuário</button>

@endsection

@section('conteudo')

	<div class="row curriculo-index">
		
		<div class="col-md-12 col-sm-12 col-xs-12">
          	<div class="x_panel modal-content">
	            <div class="x_title">
	              	<h2>Usuários <small>Utilize os comandos da tabela para reordenar e pesquisar</small></h2>
	              	<div class="clearfix"></div>
	            </div>
            	<div class="x_content">

            		<table id="datatable" class="table table-striped table-bordered">
            			<thead>
            				<tr>
            					<th>ID</th>
            					<th>Nome</th>
            					<th>E-mail</th>
                      <th>Administrador?</th>
            					<th style="min-width: 65px;">Ações</th>
            				</tr>
            			</thead>


            			<tbody>

            				{{-- Iterar pelos currículos para mostrar na tabela --}}

            				@foreach($users as $user)

            				<tr>
            					<td>{{ $user->id }}</td>
            					<td>{{ $user->name }}</td>
            					<td>{{ $user->email }}</td>
                      <td>
                        @if($user->is_admin)
                          Sim
                        @else
                          Não
                        @endif
                      </td>
            					<td>

            						{{-- Botão Editar, leva para a tela de edição do currículo --}}

            						<a href="{{ url("usuarios/$user->id/edit") }}" class="btn btn-info btn-pn btn-cor-padrao" title="Editar" data-id="{{ $user->id }}"><i class="fa fa-edit"></i></a>

            						{{-- Botão de Exclusão --}}

            						<a class="btn btn-pn btn-excluir btn-cor-perigo" data-toggle="modal" title="Excluir" data-target=".modal-excluir-curriculo" data-id="{{ $user->id }}" data-nome="{{ $user->name }}"><i class="fa fa-remove"></i></a>

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
            <h4 class="modal-title">Deseja realmente excluir o usuário <span class="nome"></span> ?</h4>
          </div>
          <div class="modal-body">
            <p>O usuário excluído não poderá ser recuperado posteriormente.</p>
          </div>
          <div class="modal-footer">
            <input type="hidden" value="" id="usuario_id">
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

        // Popular o modal com as informações do usuário à ser excluído

        $('.btn-excluir').click(function(){

          var nome = $(this).data('nome');
          var id = $(this).data('id');

          // Definir o valor do campo hidden "usuario_id" que será usando quando o usuário
          // confirmar a exclusão no modal

          $("#usuario_id").val(id);

          $('.modal-content span.nome').html(nome);

        });

        // Excluir o currículo quando o usuário confirmar no modal

        $('.btn-confirmar-modal').click(function(){

          var id = $("#usuario_id").val();

          // Enviar a requisição DELETE para o Laravel, caso positivo

          $.post("{{ url('usuarios/') }}/"+id, {
            _token  : "{{ csrf_token() }}",
            _method : 'DELETE',
            id : id
          }, function(data){

            window.location = "/usuarios";

          });

        });

      });
      
    </script>

@endsection