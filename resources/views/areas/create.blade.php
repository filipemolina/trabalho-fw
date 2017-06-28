@extends('layouts.gentellela')

@section('title')

	Cadastrar Área de Atuação

@endsection

@section('css')

	<!-- bootstrap-daterangepicker -->
    <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

@endsection

@section('menu-superior')

  <button class="btn btn-info btn-cadastrar-curriculo btn-cor-padrao modal-content" onclick="window.location='{{ url('areas/') }}'"><i class="fa fa-arrow-left"></i> Lista de Áreas de Atuação</button>

@endsection

@section('conteudo')

	{{-- Mensagem de Erro --}}

	@if(count($errors) > 0)

		@foreach($errors->all() as $error)

			<div class="alert alert-danger alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<strong>Atenção</strong> {{ $error }}
			</div>

		@endforeach

	@endif

	{{-- Mensagem de Sucesso --}}

	@if(session('mensagem'))

		<div class="alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Parabéns</strong> {{ session('mensagem') }}
		</div>

	@endif

	{{-- Fim das Mensagens --}}

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel modal-content">
			<div class="x_title">
				<h2>Cadastrar Área de Atuação <small></small></h2>
				<div class="clearfix"></div>
			</div>

			<div class="x_content">
				<br>
				<form action="{{ url('areas') }}" method="post" id="cadastro-area" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

					{{ csrf_field() }}

					{{-- Descrição --}}
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">Descrição <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ old('descricao') }}" type="text" id="descricao" name="descricao" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- Botão --}}

					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success btn-cor-neutra">Enviar</button>
						</div>
					</div>

				</form>

			</div>

		</div>

	</div>

@endsection

@section('js')

	{{-- DateRangePicker --}}
	<script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script>
    	
    $(function(){

    	$(".date-picker").daterangepicker({
			"showDropdowns": true,
			"singleDatePicker": true,
			"locale": {
				"format": "DD/MM/YYYY",
				"separator": " - ",
				"applyLabel": "Apply",
				"cancelLabel": "Cancel",
				"fromLabel": "From",
				"toLabel": "To",
				"customRangeLabel": "Custom",
				"weekLabel": "W",
				"daysOfWeek": [
				"Dom",
				"Seg",
				"Ter",
				"Qua",
				"Qui",
				"Sex",
				"Sab"
				],
				"monthNames": [
				"Janeiro",
				"Fevereiro",
				"Março",
				"Abril",
				"Maio",
				"Junho",
				"Julho",
				"Agosto",
				"Setembro",
				"Outubro",
				"Novembro",
				"Dezembro"
				],
				"firstDay": 1
			}
		});

    });

    </script>

@endsection

