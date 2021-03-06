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
				<h2>Editar Currículo de {{ $curriculo->nome }}</h2>
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
							Masculino <input type="radio" class="flat" name="sexo" id="genderM" value="M" @if($curriculo->sexo == "M") checked @endif required />
                        	 Feminino <input type="radio" class="flat" name="sexo" id="genderF" value="F" @if($curriculo->sexo == "F") checked @endif />
						</div>
					</div>

					{{-- Data de Nascimento --}}
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nascimento">Nascimento <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input value="{{ $curriculo->nascimento->format("d/m/Y") }}" data-inputmask="'mask':'99/99/9999'" type="text" id="nascimento" name="nascimento" required="required" class="form-control col-md-7 col-xs-12">
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

          {{-- Pessoa Com Deficiência --}}

          <div class="form-group">
          	<label class="control-label col-md-3 col-sm-3 col-xs-12">PCD</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="pcd" name="pcd" class="select2_group col-md-7 col-xs-12 form-control">
                <option value="1" @if ($curriculo->pcd == 1) selected="selected" @endif>Sim</option>
                <option value="0" @if (is_null($curriculo->pcd) || $curriculo->pcd == 0) selected="selected" @endif>Não</option>
              </select>
            </div>
          </div>

          {{-- Tipo de Deficiência --}}

          <div class="form-group">
          	<label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo de Deficiência</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="tipo_deficiencia" name="tipo_deficiencia" class="select2_group col-md-7 col-xs-12 form-control">
              	<option value=""        @if ($curriculo->tipo_deficiencia == '0') selected="selected" @endif>Selecione...</option>
              	<option value="visual"   @if ($curriculo->tipo_deficiencia == 'visual') selected="selected" @endif>Visual</option>
              	<option value="auditiva" @if ($curriculo->tipo_deficiencia == 'auditiva') selected="selected" @endif>Auditiva</option>
              	<option value="física"   @if ($curriculo->tipo_deficiencia == 'fisica') selected="selected" @endif>Física</option>
              	<option value="mental"   @if ($curriculo->tipo_deficiencia == 'mental') selected="selected" @endif>Mental</option>
              	<option value="multipla" @if ($curriculo->tipo_deficiencia == 'multipla') selected="selected" @endif>Múltipla</option>
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
							{{-- <input value="{{ $curriculo->bairro }}" type="text" required="required" id="bairro" name="bairro" class="form-control col-md-7 col-xs-12"> --}}

							<!-- {{ $curriculo->bairro }} -->
							<select name="bairro" id="bairro" required="required" class="form-control col-md-7 col-xs-12">

								<option value="">SELECIONE...</option>
								
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Alto Uruguai")) selected @endif value="Alto Uruguai">Alto Uruguai</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Areia Branca")) selected @endif value="Areia Branca">Areia Branca</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Banco de Areia")) selected @endif value="Banco de Areia">Banco de Areia</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("BNH")) selected @endif value="BNH">BNH</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Centro")) selected @endif value="Centro">Centro</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Chatuba")) selected @endif value="Chatuba">Chatuba</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Coréia")) selected @endif value="Coréia">Coréia</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Cosmorama")) selected @endif value="Cosmorama">Cosmorama</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Cruzeiro Do Sul")) selected @endif value="Cruzeiro Do Sul">Cruzeiro Do Sul</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Edson Passos")) selected @endif value="Edson Passos">Edson Passos</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Industrial")) selected @endif value="Industrial">Industrial</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Jacutinga")) selected @endif value="Jacutinga">Jacutinga</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Jardim Delamare")) selected @endif value="Jardim Delamare">Jardim Delamare</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Juscelino")) selected @endif value="Juscelino">Juscelino</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Rocha Sobrinho")) selected @endif value="Rocha Sobrinho">Rocha Sobrinho</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Santa Terezinha")) selected @endif value="Santa Terezinha">Santa Terezinha</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Santo Elias")) selected @endif value="Santo Elias">Santo Elias</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Vila Norma")) selected @endif value="Vila Norma">Vila Norma</option>
								<option @if(strtoupper($curriculo->bairro) == strtoupper("Vila Emil")) selected @endif value="Vila Emil">Vila Emil</option>

							</select>
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

					<?php $cont = 0; ?>

					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Área de Atuação</label>
                        <div class="col-md-6 col-sm-6 col-xs-12 div-select">
                        	
							@forelse($curriculo->areas as $area_selecionada)

	                          <select id="@if($cont == 0)area" @else{{ $cont - 1 }}" style="margin-top: 10px;" @endif name="area[]" class="select2_group col-md-7 col-xs-12 form-control">
	                          	<option value="">-- EXCLUIR! --</option>

	                          		{{-- Iterar pelar áreas de atuação --}}

									@foreach($areas as $area)

										<option value="{{ $area->id }}" @if ($curriculo->areas[$cont]->id == $area->id) selected="selected" @endif>{{ $area->descricao }}</option>

									@endforeach

	                          </select>

	                          <?php $cont++; ?>

	                        @empty

								<select id="@if($cont == 0)area" @else{{ $cont - 1 }}" style="margin-top: 10px;" @endif name="area[]" class="select2_group col-md-7 col-xs-12 form-control">
		                          	<option value="">Selecione...</option>

		                          		{{-- Iterar pelar áreas de atuação --}}

										@foreach($areas as $area)

											<option value="{{ $area->id }}">{{ $area->descricao }}</option>

										@endforeach

		                          </select>

	                        @endforelse
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