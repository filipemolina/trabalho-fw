@extends('layouts.pdf')

@section('title')

	Comprovante de Inscrição

@endsection

@push('css')

	<style>
		.bold{ font-weight: bold;  }
		.separador 
		{     
			border-bottom: 1px solid #ccc;
		    padding-top: 0; 
		}
	</style>

@endpush

@section('conteudo')

	{{-------------------------- Cabeçalho --------------------------}}

	<div style="max-width: 100%">
		
		<div style="float: left;">
			<img style="width: 100px;" src="img/brasao.png" alt="">
		</div>

		<div style="display: block; float: left; font-weight: bold; font-size: 25px; width: 86%; text-align: center; margin-left: -100px;">
			Prefeitura Municipal de Mesquita
		</div>

		<br><br>

		<div style="display: block; float: left; width: 86%; text-align: center; font-size: 20px; margin-left: -100px;">
			Secretaria Municipal de Urbanismo e Meio Ambiente
		</div>

		<div style="clear: both;"></div>

	</div>

	<div style="max-width: 100%">
		
		<h2 style="text-align: center; text-transform: uppercase;">COMPROVANTE DE INSCRIÇÃO</h2>

		<h2 style="text-align: center; text-transform: uppercase;">Nº {{ $participante->codigo_inscricao }}</h2>

	</div>

	<div style="max-width: 100%; font-size: 10px;">

		{{-----------------------------------Informações do Participante ------------------------------------}}

		<table style=" width: 100%;">

			<thead>
				
				<tr>
					<th colspan="3" style="font-size: 18px; font-weight: bold; text-align: center; background-color: #3D276B; color: #fff;">PARTICIPANTE</th>
				</tr>

			</thead>

			<tbody>

				<tr>
					<td colspan="3" style="padding-top: 10px;"></td>
				</tr>
				
				<tr style="font-size: 14px; margin-top: 10px">
				
					<td>
						<span class="bold">Nome: </span> {{ $participante->nome }}
					</td>

					<td>
						<span class="bold">CPF: </span> {{ $participante->cpf }}
					</td>

					<td>
						<span class="bold">Nascimento: </span> {{ implode("/",array_reverse(explode("-",$participante->nascimento))) }}
					</td>

				</tr>

				<tr style="font-size: 14px">

					<td colspan="2">
						<span class="bold">Endereco: </span> {{ $participante->endereco->logradouro }} nª {{ $participante->endereco->numero }} - {{ $participante->endereco->bairro }} - Mesquita
					</td>

					<td>
						<span class="bold">CEP: </span>{{ $participante->endereco->cep }}
					</td>

				</tr>

				<tr style="font-size: 14px">

					<td>
						<span class="bold">Celular: </span> {{ $participante->telefones[0]->numero or "" }}
					</td>

					<td>
						<span class="bold">Residencial: </span> {{ $participante->telefones[1]->numero or "" }}
					</td>

					<td>
						<span class="bold">Necessidades Especiais: </span> {{ $participante->necessidades_especiais ? "Sim" : "Não" }}
					</td>

				</tr>

			</tbody>

		</table>

		{{-----------------------------------Informações do Coparticipante ------------------------------------}}

		@if(count($participante->coparticipante) > 0)

			<table style=" width: 100%; margin-top: 15px;">

				<thead>
					
					<tr>
						<th colspan="3" style="font-size: 18px; font-weight: bold; text-align: center; background-color: #3D276B; color: #fff;">COPARTICIPANTE</th>
					</tr>

				</thead>

				<tbody>

					<tr>
						<td colspan="3" style="padding-top: 10px;"></td>
					</tr>
					
					<tr style="font-size: 14px; margin-top: 10px">
					
						<td>
							<span class="bold">Nome: </span> {{ $participante->coparticipante->nome }}
						</td>

						<td>
							<span class="bold">CPF: </span> {{ $participante->coparticipante->cpf }}
						</td>

						<td>
							<span class="bold">Nascimento: </span> {{ implode("/",array_reverse(explode("-",$participante->coparticipante->nascimento))) }}
						</td>

					</tr>

					<tr style="font-size: 14px">

						<td colspan="2">
							<span class="bold">Endereco: </span> {{ $participante->coparticipante->endereco->logradouro }} nª {{ $participante->coparticipante->endereco->numero }} - {{ $participante->coparticipante->endereco->bairro }} - Mesquita
						</td>

						<td>
							<span class="bold">CEP: </span>{{ $participante->coparticipante->endereco->cep }}
						</td>

					</tr>

					<tr style="font-size: 14px">

						<td>
							<span class="bold">Celular: </span> {{ $participante->coparticipante->telefones[0]->numero or "" }}
						</td>

						<td>
							<span class="bold">Residencial: </span> {{ $participante->coparticipante->telefones[1]->numero or "" }}
						</td>

						<td>
							<span class="bold">Necessidades Especiais: </span> {{ $participante->necessidades_especiais ? "Sim" : "Não" }}
						</td>

					</tr>

				</tbody>

			</table>

		@endif

		{{-----------------------------------Informações dos Dependentes ------------------------------------}}

		<table style=" width: 100%; margin-top: 15px;">

			<thead>
				
				<tr>
					<th colspan="2" style="font-size: 18px; font-weight: bold; text-align: center; background-color: #3D276B; color: #fff;">DEPENDENTES</th>
				</tr>

			</thead>

			<tbody>

				@foreach($participante->dependentes as $dependente)

					<tr>
						<td colspan="2" style="padding-top: 10px;"></td>
					</tr>
					
					<tr style="font-size: 14px; margin-top: 10px">
					
						<td style="text-align: center;">
							<span class="bold">Nome: </span>{{ $dependente->nome }}
						</td>

						<td style="text-align: center;">
							<span class="bold">Nascimento: </span>{{ implode("/",array_reverse(explode("-",$dependente->nascimento))) }}
						</td>

					</tr>

					<tr style="font-size: 14px; margin-top: 10px; border-bottom: 2px solid #000;">

						<td style="text-align: center;">
							<span class="bold">Parentesco: </span>{{ $dependente->parentesco }} 
						</td>

						<td style="text-align: center;">
							<span class="bold">Necessidades Especiais: </span>{{ $dependente->necessidades_especiais ? "Sim" : "Não" }} 
						</td>

					</tr>

				@endforeach

			</tbody>

		</table>

		{{-----------------------------------Informações dos Dependentes ------------------------------------}}

		<table style=" width: 100%; margin-top: 15px;">

			<thead>
				
				<tr>
					<th colspan="2" style="font-size: 18px; font-weight: bold; text-align: center; background-color: #3D276B; color: #fff;">RENDA / TEMPO</th>
				</tr>

			</thead>

			<tbody>

				<tr>
					<td colspan="2" style="padding-top: 10px;"></td>
				</tr>

				<tr style="font-size: 14px; margin-top: 10px; border-bottom: 2px solid #000;">
					
					<td style="text-align: center; width: 58%;">
						<span class="bold">Renda: </span>R$ {{ number_format($participante->renda_familiar, 2) }}
					</td>

					<td style="text-align: center">
						<span class="bold">Tempo de Moradia: </span>{{ date('Y') - date('Y', strtotime($participante->tempo_residencia)) }} Anos
					</td>

				</tr>

				<tr>
					<td colspan="2" style="padding-top: 50px;"></td>
				</tr>

				<tr>
					<td colspan="2" style="text-align: center">
						___________________________________________________________________________________
					</td>
				</tr>

				<tr style="font-size: 14px; margin-top: 10px; border-bottom: 2px solid #000;">
					<td colspan="2" style="text-align: center">
						Assinatura do Participante
					</td>
				</tr>

				<tr style="font-size: 14px; margin-top: 10px; border-bottom: 2px solid #000;">
					<td colspan="2" style="text-align: center">
						<span class="bold">{{ date("d/m/Y", strtotime($participante->created_at)) }}</span>
					</td>
				</tr>

			</tbody>

		</table>

	</div>

@endsection