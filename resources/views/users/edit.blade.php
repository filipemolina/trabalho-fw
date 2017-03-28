@extends('layouts.gentellela')

@section('title')

    Editar Usuário

@endsection

@section('menu-superior')

    <button class="btn btn-info btn-cadastrar-curriculo" onclick="window.location='{{ url('usuarios/') }}'"><i class="fa fa-arrow-left"></i> Lista de Usuários</button>

@endsection

@section('css')



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
		<div class="x_panel">
			<div class="x_title">
				<h2>Editar Dados do Usuário <small></small></h2>
				<div class="clearfix"></div>
			</div>

			<div class="x_content">
				<br>
                <!-- {{ url('usuarios') }} -->
				<form action="{{ url("usuarios/$usuario->id") }}" method="POST" id="cadastro-area" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

					{{ csrf_field() }}
                    {{ method_field('PUT') }}

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-3 control-label">Nome <span class="required">*</span></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $usuario->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-3 control-label">E-Mail <span class="required">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $usuario->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="is_admin" class="col-md-3 control-label"> É Administrador </label>

                            <div class="col-md-6">
                                
                                <select name="is_admin" id="is_admin" class="form-control">
                                    <option value="0" @if(!$usuario->is_admin) selected="selected" @endif >Não</option>
                                    <option value="1" @if($usuario->is_admin) selected="selected" @endif >Sim</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-3 control-label">Senha <span class="required">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-3 control-label">Confirmar Senha <span class="required">*</span></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<button type="submit" class="btn btn-success">Enviar</button>
							</div>
						</div>

				</form>

			</div>

		</div>

	</div>

@endsection

@section('js')



@endsection