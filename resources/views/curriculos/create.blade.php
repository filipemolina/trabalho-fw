@extends('layouts.gentellela')

@section('title')

Cadastrar Currículo

@endsection

@section('css')

	<!-- bootstrap-daterangepicker -->
    <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

@endsection

@section('menu-superior')

  <button class="btn btn-info btn-cadastrar-curriculo" onclick="window.location='{{ url('curriculos/') }}'"><i class="fa fa-arrow-left"></i> Lista de Currículos</button>

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

				<form action="{{ url('curriculos') }}" method="post" id="cadastro-curriculo" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

					{{ csrf_field() }}

					{{---------------------------------------- Documentação ----------------------------------------}}

					{{-- Nome --}}
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nome">Nome <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ old('nome') }}" type="text" id="nome" name="nome" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- Sexo --}}
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="sexo">Sexo <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							Masculino <input type="radio" class="flat" name="sexo" id="genderM" value="M" @if(old('sexo') == "M") checked="checked" @endif required />
                        	 Feminino <input type="radio" class="flat" name="sexo" id="genderF" value="F" @if(old('sexo') == "F") checked="checked" @endif />
						</div>
					</div>

					{{-- Data de Nascimento --}}
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nascimento">Nascimento <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ old('nascimento') }}" type="text" id="nascimento" name="nascimento" required="required" class="date-picker form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- CPF --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="cpf">CPF <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ old('cpf') }}" data-inputmask="'mask':'999.999.999-99'" type="text" id="cpf" name="cpf" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- RG --}}


					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="rg">RG
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ old('rg') }}" type="text" id="rg" name="rg" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- PIS / PASEP --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="pis">PIS / PASEP
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ old('pis') }}" type="text" id="pis" name="pis" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- CTPS --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ctps">CTPS
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ old('ctps') }}" type="text" id="ctps" name="ctps" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
					
					{{-- Título --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="titulo">Título Eleitoral <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ old('titulo') }}" type="text" id="titulo" name="titulo" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- Linha Divisória --}}

					<div class="ln_solid"></div>

					{{-------------------------------- Info. Adicional ----------------------------------}}

					{{-- Indicação Política --}}

					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Indicação Política</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="indicacao_politica" id="indicacao_politica" value="{{ old('indicacao_politica') }}">
                        </div>
                     </div>

                    {{-- Formação --}}

					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Formação</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="formacao" name="formacao" class="select2_group col-md-7 col-xs-12 form-control">
                          	<option value="">Selecione...</option>
                            <option value="Fundamental" @if (old('formacao') == 'Fundamental') selecte="selected" @endif>Fundamental</option>
                            <option value="Médio" @if (old('formacao') == 'Médio') selecte="selected" @endif>Médio</option>
                            <option value="Superior" @if (old('formacao') == 'Superior') selecte="selected" @endif>Superior</option>
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
							<input data-inputmask="'mask':'9999-9999'" value="{{ old('telefone_1') }}" type="text" id="telefone_1" name="telefone_1" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- Telefone 2 --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefone_2">Telefone Celular
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input data-inputmask="'mask':'99999-9999'" value="{{ old('telefone_2') }}" type="text" id="telefone_2" name="telefone_2" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

                    {{-- Rua --}}

                    <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="rua">Logradouro <span class="required">*</span>
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input value="{{ old('rua') }}" type="text" required="required" id="rua" name="rua" class="form-control col-md-7 col-xs-12">
						</div>
						
						{{-- Número --}}

						<label class="control-label col-md-1 col-sm-1 col-xs-12" for="rua">Nº <span class="required">*</span></label>
						<div class="col-md-1 col-sm-1 col-xs-12">
							<input value="{{ old('numero') }}" type="text" required="required" id="numero" name="numero" class="form-control col-md-7 col-xs-12">
						</div>

					</div>

					{{-- Complemento --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="complemento">Complemento
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ old('complemento') }}" type="text" id="complemento" name="complemento" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- Bairro --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="bairro">Bairro <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ old('bairro') }}" type="text" required="required" id="bairro" name="bairro" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					{{-- CEP --}}

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="cep">CEP
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ old('cep') }}" type="text" id="cep" name="cep" data-inputmask="'mask':'99999-999'" class="form-control col-md-7 col-xs-12">
						</div>
					</div>

					<div class="ln_solid"></div>

					{{-------------------- Comentários e Área de Atuação ----------------------}}

					{{-- Área de Atuação --}}

					<div class="form-group areas">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Área de Atuação</label>
                        <div class="col-md-6 col-sm-6 col-xs-12 div-select">
                          <select id="area" name="area[]" class="select2_group col-md-7 col-xs-12 form-control">
                          	<option value="">Selecione...</option>

                          		{{-- Iterar pelar áreas de atuação --}}

								@foreach($areas as $area)

									<option value="{{ $area->id }}" @if (old('area') == $area->id) selected="selected" @endif>{{ $area->descricao }}</option>

								@endforeach

                          </select>
                        </div>
	
						{{-- Botão para cadastro da área de atuação --}}

                        <div class="col-md-3">
                        	<a href="#" class="btn btn-info btn-nova-linha"> <i class="fa fa-plus"></i> </a>
                        </div>
                    </div>

                    {{-- Botão para inserir mais uma linha no formulario para cadastro de outra área de atuação --}}

                    <div class="form-group" style="text-align: center;">
                    	<a href="#" data-toggle="modal" data-target=".modal-cadastra-area" class="btn btn-info"> Nova Área de Atuação </a>
                    </div>

                    {{-- Comentários --}}

					<div class="form-group">
						<label for="comentario" class="control-label col-md-3 col-sm-3 col-xs-12">Comentários</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<textarea class="col-md-12 col-sm-12 col-xs-12" name="comentarios" id="comentarios">{{ old('comentarios') }}</textarea>
						</div>
					</div>

					{{------------------------------------------ Botão ------------------------------------------}}

					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success">Enviar</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>

	{{-- Modal --}}

	<div class="modal fade bs-example-modal-sm modal-cadastra-area" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" style="text-align: center;">Insira a nova Área de Atuação: </h4>
				</div>
				<div class="modal-body">

					{{-- Formulário de cadastro da área de atuação --}}

					<form id="cadastrar-area" action="{{ url('areas') }}" method="post" id="cadastro-curriculo" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">Descrição <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input value="" type="text" id="descricao" name="descricao" required="required" class="form-control col-md-7 col-xs-12">
							</div>
						</div>

					</form>
				</div>
				<div class="modal-footer">
					<input type="hidden" value="" id="curriculo_id">
					<button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-success btn-confirmar-modal">Cadastrar</button>
				</div>

			</div>
		</div>
	</div>

    {{-- /Modal --}}

@endsection

@section('js')

	{{-- DateRangePicker --}}
	<script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

	<script>

		var incremento = 0;

		$(function(){

			$(":input").inputmask();

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

			// Criar uma nova linha para cadastro de outra área de atuação

			$("a.btn-nova-linha").click(function(e){

				e.preventDefault();

				// Clona o select, atribui um id começando com 0, coloca uma margem de 10 pixels e adiciona
				// à div

				$("select#area").clone().attr('id', incremento).css('margin-top', '10px').appendTo('div.div-select'); 

				// Incrementa a variável utilizada para gerar os idsyyy

				incremento++;

			});

			// Realizar o cadastro de área de atuação e atualizar o select com a opção que acabou de ser cadastrada

			$(".btn-confirmar-modal").click(function(event){

				event.preventDefault();

				$.post('{{ url('areas/') }}', {
					_token    : "{{ csrf_token() }}",
					descricao : $("input#descricao").val()
				}, function(data){

					// Transformar o retorno em um objeto JSON

					data = JSON.parse(data);

					// Apagar o valor digitado

					$("#input#descricao").val("");

					// Fechar o modal

					$(".modal-cadastra-area").modal('toggle');

					// Limpar a opção selecionada, se houver

					$("select#area").find('option:selected').removeAttr('selected');

					// Decidir em qual select será incluida a nova opção

					if(incremento > 0)
					{
						// Inserir a nova opção e selecioná-la

						$("select#"+(incremento-1)).append($('<option>', {
							value : data.id,
							text  : data.descricao
						}).attr('selected', 'selected'));	
					}
					else
					{
						// Inserir a nova opção e selecioná-la

						$("select#area").append($('<option>', {
							value : data.id,
							text  : data.descricao
						}).attr('selected', 'selected'));
					}

					

				});

				return false;

			});

		});
	</script>

@endsection