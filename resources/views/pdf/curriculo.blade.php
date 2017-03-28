@extends('layouts.pdf')

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
			Secretaria Municipal de Trabalho
		</div>

		<div style="clear: both;"></div>

	</div>

	{{-------------------------- Campos do Currículo --------------------------}}

	{{-- Nome --}}

	<h2 style="text-align: center;">{{ $curriculo->nome }}</h2>

	{{-- Endereço --}}

	<p style="text-align: center;">{{ $curriculo->rua }} nº {{ $curriculo->numero }} {{ $curriculo->complemento }}, {{ $curriculo->bairro }} - Mesquita - RJ. CEP: {{ $curriculo->cep }}</p>

	{{-- Telefones --}}

	<p style="text-align: center;">
		<span style="font-weight: bold"> Telefones: </span> {{ $curriculo->telefone_1 or "" }} - {{ $curriculo->telefone_2 or "" }}
	</p>

	{{-- Documentação --}}

	<br>

	<p style="font-weight: bold; font-size: 20px; text-decoration: underline;">Documentaçao:</p>

	<br>

		<table style="width: 100%;">
				
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

		<p> <span style="font-weight: bold; margin-right: 10px;">Data de Nascimento: </span> {{ $curriculo->nascimento }} </p>

		<p> <span style="font-weight: bold; margin-right: 10px;">Formação: </span> {{ $curriculo->formacao }} </p>

		<p> <span style="font-weight: bold; margin-right: 10px;"> Área de Atuação Desejada: </span>  {{ $curriculo->areas()->first()->descricao }} </p>

		<p> <span style="font-weight: bold; margin-right: 10px;"> Comentários: </span></p>

		<p>{{ $curriculo->comentarios }}</p>


		{{-------------------------- Área da Assinatura --------------------------}}

		<br><br><br>	

		<p style="text-align: center; font-weight: bold;">___________________________________________________</p>
		<p style="text-align: center">Secretário Municipal de Trabalho</p>

@endsection