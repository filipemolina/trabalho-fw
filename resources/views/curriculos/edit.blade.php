@extends('layouts.gentellela')

@section('title')

	Editar Currículo {{ $curriculo->id }}

@endsection

@section('css')



@endsection

@section('menu-superior')

  <button class="btn btn-info btn-cadastrar-curriculo" onclick="location.href='{{ url('curriculos/') }}'"><i class="fa fa-arrow-left"></i> Lista de Currículos</button>

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
				<h2>Cadastrar Currículo <small>Atenção aos itens obrigatórios.</small></h2>
				<div class="clearfix"></div>
			</div>

			<div class="x_content">
				<br>
				<form action="{{ url('curriculos/'.$curriculo->id) }}" method="post" id="edita-curriculo" data-parsley-validate="" class="form-horizontal form-label-left edit" novalidate="">

					{{ csrf_field() }}

					{{ method_field('PUT') }}

					{{---------------------------------------- Documentação ----------------------------------------}}

					{{-- Nome --}}
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nome">Nome <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ $curriculo->nome }}" type="text" id="nome" name="nome" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- Sexo --}}
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="sexo">Sexo <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							Masculino <input type="radio" class="flat" name="sexo" id="genderM" value="M" @if($curriculo->sexo == "M") checked="checked" @endif required />
                        	 Feminino <input type="radio" class="flat" name="sexo" id="genderF" value="F" @if($curriculo->sexo == "F") checked="checked" @endif />
						</div>
					</div>

					{{-- Data de Nascimento --}}
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nascimento">Nascimento <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ $curriculo->nascimento }}" type="text" id="nascimento" name="nascimento" required="required" class="date-picker form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- CPF --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="cpf">CPF <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ $curriculo->cpf }}" data-inputmask="'mask':'999.999.999-99'" type="text" id="cpf" name="cpf" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- RG --}}


					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="rg">RG
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ $curriculo->rg }}" type="text" id="rg" name="rg" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- PIS / PASEP --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="pis">PIS / PASEP
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ $curriculo->pis }}" type="text" id="pis" name="pis" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- CTPS --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ctps">CTPS
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ $curriculo->ctps }}" type="text" id="ctps" name="ctps" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
					
					{{-- Título --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="titulo">Título Eleitoral <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ $curriculo->titulo }}" type="text" id="titulo" name="titulo" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- Linha Divisória --}}

					<div class="ln_solid"></div>

					{{-------------------------------- Info. Adicional ----------------------------------}}

					{{-- Indicação Política --}}

					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Indicação Política</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="indicacao_politica" name="indicacao_politica" class="select2_group col-md-7 col-xs-12 form-control">
                            <option value="0" @if ($curriculo->indicacao_politica == "0") selected="selected" @endif>Não</option>
                            <option value="1" @if ($curriculo->indicacao_politica == "1") selected="selected" @endif>Sim</option>
                          </select>
                        </div>
                     </div>

                    {{-- Formação --}}

					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Formação</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="formacao" name="formacao" class="select2_group col-md-7 col-xs-12 form-control">
                          	<option value="">Selecione...</option>
                            <option value="Fundamental" @if ($curriculo->formacao == 'Fundamental') selected="selected" @endif>Fundamental</option>
                            <option value="Médio" @if ($curriculo->formacao == 'Médio') selected="selected" @endif>Médio</option>
                            <option value="Superior" @if ($curriculo->formacao == 'Superior') selected="selected" @endif>Superior</option>
                          </select>
                        </div>
                    </div>

                    {{------------------------------------------ Endereço ------------------------------------------}}

                    {{-- Linha Divisória --}}

                    <div class="ln_solid"></div>

                    {{-- Telefone 1 --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefone_1">Telefone Fixo
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input data-inputmask="'mask':'9999-9999'" value="{{ $curriculo->telefone_1 }}" type="text" id="telefone_1" name="telefone_1" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- Telefone 2 --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefone_2">Telefone Celular
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input data-inputmask="'mask':'99999-9999'" value="{{ $curriculo->telefone_2 }}" type="text" id="telefone_2" name="telefone_2" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

                    {{-- Rua --}}

                    <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="rua">Logradouro <span class="required">*</span>
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input value="{{ $curriculo->rua }}" type="text" required="required" id="rua" name="rua" class="form-control col-md-7 col-xs-12">
						</div>
						
						{{-- Número --}}

						<label class="control-label col-md-1 col-sm-1 col-xs-12" for="rua">Nº <span class="required">*</span></label>
						<div class="col-md-1 col-sm-1 col-xs-12">
							<input value="{{ $curriculo->numero }}" type="text" required="required" id="numero" name="numero" class="form-control col-md-7 col-xs-12">
						</div>

					</div>

					{{-- Complemento --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="complemento">Complemento
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ $curriculo->complemento }}" type="text" id="complemento" name="complemento" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- Bairro --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="bairro">Bairro <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ $curriculo->bairro }}" type="text" required="required" id="bairro" name="bairro" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- CEP --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="cep">CEP
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ $curriculo->cep }}" type="text" id="cep" name="cep" data-inputmask="'mask':'99999-999'" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					<div class="ln_solid"></div>

					{{-------------------- Comentários e Área de Atuação ----------------------}}

					{{-- Área de Atuação --}}

					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Área de Atuação</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="area" name="area" class="select2_group col-md-7 col-xs-12 form-control">
                          	<option value="">Selecione...</option>

                          		{{-- Iterar pelar áreas de atuação --}}

								@foreach($areas as $area)

									<option value="{{ $area->id }}" @if ($curriculo->areas->contains($area->id)) selected="selected" @endif>{{ $area->descricao }}</option>

								@endforeach

                          </select>
                        </div>
                    </div>

                    {{-- Comentários --}}

					<div class="form-group">
						<label for="comentario" class="control-label col-md-3 col-sm-3 col-xs-12">Comentários</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<textarea class="col-md-12 col-sm-12 col-xs-12" name="comentarios" id="comentarios">{{ $curriculo->comentarios }}</textarea>
						</div>
					</div>

					{{------------------------------------------ Botão ------------------------------------------}}

					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success">Alterar</button>
							<a href="{{ url('curriculos') }}" class="btn btn-danger">Cancelar</a>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>

@endsection

@section('js')



@endsection