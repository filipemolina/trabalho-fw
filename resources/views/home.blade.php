@extends('layouts.gentellela')

@section('title')

    Dashboard

@endsection

@section('css')



@endsection

@section('menu-superior')

    <button class="btn-cadastrar-curriculo btn btn-cor-perigo modal-content" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fa fa-close"></i> Sair </button>
    <button class="btn-cadastrar-curriculo btn btn-cor-padrao modal-content" onclick="window.location='{{ url('/configuracoes') }}'"> <i class="fa fa-key"></i> Alterar Senha </button>
    <button class="btn-cadastrar-curriculo btn btn-cor-padrao modal-content" onclick="window.location='{{ url('areas/create') }}'"> <i class="fa fa-suitcase"></i> Cadastrar Área de Atuação </button>
    <button class="btn-cadastrar-curriculo btn btn-cor-padrao modal-content" onclick="window.location='{{ url('curriculos/create') }}'"> <i class="fa fa-id-card"></i> Cadastrar Currículo </button>

@endsection

@section('conteudo')

  
    @include('includes.home.topo')

    @include('includes.home.bairros')

    @include('includes.home.areas')

    
<br>
<!-- /page content -->

@endsection

@section('js')

     @include('includes.home.scripts')

@endsection