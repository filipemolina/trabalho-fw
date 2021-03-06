@extends('layouts.curriculo')

@section('conteudo')

	{{-------------------------- Cabeçalho --------------------------}}

	<div style="max-width: 100%">
		
		<div style="float: left;">
			<img style="width: 100px;" src="{{ url("img/brasao.png") }}" alt="">
		</div>

		<div style="display: block; float: left; font-weight: bold; font-size: 25px; width: 100%; text-align: center; margin-left: -100px;">
			Prefeitura Municipal de Mesquita
		</div>

		<br><br>

		<div style="display: block; float: left; width: 100%; text-align: center; font-size: 20px; margin-left: -100px;">
			Secretaria Municipal de Trabalho, Desenvolvimento<br> Econômico e Agricultura
		</div>

		<div style="clear: both;"></div>

	</div>

	{{-------------------------- Campos do Currículo --------------------------}}

	<h2 style="text-align:center;">ENCAMINHAMENTO</h2>

	{{-- Nome --}}

	<h2 style="text-align: center;">{{ strtoupper($curriculo->nome) }}</h2>

	{{-- Endereço --}}

	<p style="text-align: center;">{{ strtoupper($curriculo->rua) }} Nº {{ strtoupper($curriculo->numero) }} {{ strtoupper($curriculo->complemento) }}, {{ strtoupper($curriculo->bairro) }} - MESQUITA - RJ. CEP: {{ strtoupper($curriculo->cep) }}</p>

	{{-- Telefones --}}

	<p style="text-align: center;">
		<span style="font-weight: bold"> Telefones: </span> {{ $curriculo->telefone_1 or "" }} - {{ $curriculo->telefone_2 or "" }}
	</p>

	{{-- Documentação --}}

	<br>

	<p style="font-weight: bold; font-size: 20px; text-decoration: underline;">Documentaçao:</p>

	<br>

		<table cellpadding="0" cellspacing="0" style="width: 100%;">
				
			{{-- CPF --}}

			<tr>
				<td><span style="font-weight:bold;">CPF:</span></td>
				<td style="text-align: center;">{{ $curriculo->cpf }}</td>
			</tr>

			{{-- RG --}}

			<tr>
				<td><span style="font-weight:bold;">RG:</span></td>
				<td style="text-align: center;">{{ $curriculo->rg or ""}}</td>
			</tr>

			{{-- PIS / PASEP --}}

			<tr>
				<td><span style="font-weight:bold;">PIS / PASEP:</span></td>
				<td style="text-align: center;">{{ $curriculo->pis or ""}}</td>
			</tr>

			{{-- Carteira de Trabalho --}}

			<tr>
				<td><span style="font-weight:bold;">CTPS:</span></td>
				<td style="text-align: center;">{{ $curriculo->ctps or "" }}</td>
			</tr>

			{{-- Título Eleitoral --}}

			<tr>
				<td><span style="font-weight:bold;">Título Eleitoral:</span></td>
				<td style="text-align: center;">{{ $curriculo->titulo or "" }}</td>
			</tr>
		</table>

		{{-- Informações Adicionais --}}

		<br>

		<p style="font-weight: bold; font-size: 20px; text-decoration: underline;">Informações Adicionais:</p>

		<p> <span style="font-weight: bold; margin-right: 10px;">Sexo: </span> @if($curriculo->sexo == "M") Masculino @else Feminino @endif </p>

		<p> <span style="font-weight: bold; margin-right: 10px;">Data de Nascimento: </span> {{ $curriculo->nascimento->format('d/m/Y') }} </p>

		<p> <span style="font-weight: bold; margin-right: 10px;">Formação: </span> {{ $curriculo->formacao }} </p>

		{{-- Verificar se o usuário possui áreas de atuação cadastradas --}}

		@if($curriculo->areas()->count())

			<p> <span style="font-weight: bold; margin-right: 10px;"> Área de Atuação Desejada: </span> {{ $curriculo->areas()->first()->descricao }} </p>

		@endif

		@if($curriculo->pcd)

			<p>
				<span style="font-weight: bold; margin-right: 1-px">Pessoa com Deficiência: </span>
				{{ ucfirst($curriculo->tipo_deficiencia) }}
			</p> 

		@endif

		<p> <span style="font-weight: bold; margin-right: 10px;"> Comentários: </span></p>

		<p>{{ $curriculo->comentarios }}</p>


		{{-------------------------- Área da Assinatura --------------------------}}

		<br><br><br>	

		<p style="text-align: center; font-weight: bold;">___________________________________________________</p>
		<p style="text-align: center">Secretaria Municipal de Trabalho, Desenvolvimento<br> Econômico e Agricultura</p>

@endsection