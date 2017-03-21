@extends('layouts.gentellela')

@section('title')

	Configurações

@endsection

@section('css')

	

@endsection

@section('menu-superior')

	<button class="btn btn-info btn-cadastrar-curriculo" onclick="window.location = '{{ url('/') }}'"><i class="fa fa-arrow-left"></i> Dashboard</button>

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

	<div class="col-md-5 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Trocar Senha <small></small></h2>
				<div class="clearfix"></div>
			</div>

			<div class="x_content">

				<form method="post" action="{{ url('/trocarsenha') }}" class="form-horizontal form-label-left">
					
					{{ csrf_field() }}

					<div class="form-group">
						
						<label for="password" class="col-md-3 control-label">Senha: <span class="required">*</span></label>

						<div class="col-md-6">
							<input id="password" type="password" class="form-control" name="password" required>
						</div>

					</div>

					<div class="form-group">
                        <label for="password-confirm" class="col-md-3 control-label">Repetir <span class="required">*</span></label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group">
                    	<button type="submit" class="btn btn-success"> Enviar </button>
                    </div>

				</form>

			</div>

		</div>

	</div>

@endsection

@section('js')



@endsection