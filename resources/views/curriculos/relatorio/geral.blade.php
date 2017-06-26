@extends('layouts.pdf')

@section('title')

	Relatório Geral

@endsection

@section('conteudo')

	{{-------------------------- Cabeçalho --------------------------}}

	<div style="max-width: 100%">
		
		<div style="float: left; margin-bottom: 15px;">
			<img style="width: 100px;" src="{{ url("img/brasao.png") }}" alt="">
		</div>

		<div style="display: block; float: left; font-weight: bold; font-size: 25px; width: 86%; text-align: center; margin-left: -100px;">
			Prefeitura Municipal de Mesquita
		</div>

		<br><br>

		<div style="display: block; float: left; width: 86%; text-align: center; font-size: 18px; margin-left: -110px;">
			Secretaria de Trabalho, Desenvolvimento Econômico e Agricultura
		</div>

	</div>

	<div style="max-width: 90%;">

		<h2 style="text-align: center; text-transform: uppercase; margin-bottom: -50px;"> RELATÓRIO {{$nome_relatorio}}<h2>

	</div>

	<div style="max-width: 100%; font-size: 10px; ">

		{{-- Iterar pela lista de curriculos--}}

		{{-- Contador de linhas --}}

		<?php $cont = 0; ?>

		@foreach($curriculos as $curriculo)

			{{-- Iniciar uma página --}}

			@if($cont == 0)

				<page size="A4">

				{{--  Caso seja a primeira linha da página, incluir o cabeçalho --}}

				<table style=" width: 100%;" class="page">
		
					<tr style="background: #3D276B; color: white; text-align: center">

						{{-- Iterar pela lista de cabeçalhos e criar um para cada item enviado --}}

						@foreach($cabecalhos as $cabecalho)

							<th style="border: 1px solid black; text-transform: uppercase;">{{ $cabecalho }}</th>

						@endforeach

					</tr>

			@endif

					<tr>
						{{-- Iterar pelos cabecalhos e preencher o valor correspondente --}}
						
						@foreach($cabecalhos as $indice => $valor)
							
							<td style="border: 1px solid black; text-align: center; text-transform: uppercase;">{{ $curriculo[$indice] }}</td>

						@endforeach

					</tr>

			{{-- Finalizar uma página após 48 linhas --}}

			@if($cont == 51)

				<?php $cont = 0; ?>

				</table>

				</page>

			@else

				<?php $cont++; ?>

			@endif
		
		@endforeach

	</div>

@endsection
