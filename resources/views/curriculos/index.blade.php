@extends('layouts.gentellela')

{{-- CSS Adicional Necessário --}}

@section('css')

	<!-- Datatables -->

    <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

@endsection

@section('menu-superior')

  <button class="btn btn-info btn-cadastrar-curriculo btn-cor-padrao modal-content" onclick="location.href='{{ url('curriculos/create') }}'"> <i class="fa fa-id-card"></i> Cadastrar Currículo</button>

@endsection

@section('conteudo')

  <div class="row">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel modal-content" style="height: auto;">
        <div class="x_title">
          <h2>Busca Avançada</h2>
          <ul class="nav navbar-right panel_toolbox" style="min-width: 0px;">
            <li><a class="limpar1 btn btn-pn btn-cor-perigo" data-toggle="tooltip" title="Limpar campos"><i class="fa fa-remove"></i></a></li>
            <li><a class="collapse-link btn btn-pn btn-cor-padrao" data-toggle="tooltip" title="Expandir / Reduzir"><i class="fa fa-chevron-down"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content" style="display: none;">

          <div class="row">

            <div class="col-md-3 form-group">
              <label for="nome">
                  Nome
                  
                  <div class="input-group ">

                      <input type="text" id="nome" class="busca form-control col-md-12 input-sm" data-column="0">

                      <a data-column="0" style="margin-right: 0; margin-bottom: 3px;" class="span-clear hide btn btn-pn btn-cor-perigo"><i class="glyphicon glyphicon-remove" style="margin-top: -10px;"></i></a>

                  </div>
              </label>
            </div>

            <div class="col-md-3">
                <label for="indicacao">
                    Bairro

                    <div class="input-group ">
                        <input type="text" id="bairro" data-column="3" class="busca form-control input-sm" />
                        <a data-column="3" style="margin-right: 0; margin-bottom: 3px;" class="span-clear hide btn btn-pn btn-cor-perigo"><i class="glyphicon glyphicon-remove" style="margin-top: -10px;"></i></a>                        
                    </div>
                </label>
            </div>

            <div class="col-md-3">
              <label for="min">
                Idade Mínima:

                <div class="input-group ">
                  <input type="number" id="min" class="busca-idade form-control input-sm" />
                  <a data-column="min" style="margin-right: 0; margin-bottom: 3px;" class="span-clear hide btn btn-pn btn-cor-perigo"><i class=" glyphicon glyphicon-remove" style="margin-top: -10px;"></i></a>

                </div>
              </label>  
            </div>

            <div class="col-md-3">
              <label for="min">
                  Idade Máxima:

                  <div class="input-group ">
                      <input type="number" id="max" class="busca-idade form-control input-sm" /></label>
                      <a data-column="max" style="margin-right: 0; margin-bottom: 3px;" class=" span-clear hide btn btn-pn btn-cor-perigo"><i class=" glyphicon glyphicon-remove" style="margin-top: -10px;"></i></a>

                  </div>
              </label>
            </div>

          </div>

          <div class="row">
            
            <div class="col-md-2">
              <label for="sexo">

                Sexo

                <div class="input-group ">

                  <select type="text" id="sexo" data-column="2" class="busca form-control input-sm">

                    <option value=""> Selecione </option>
                    <option> Masculino </option>
                    <option> Feminino </option>
                    <option> Ambos </option>
                    
                  </select>

                  <a data-column="2" style="margin-right: 0; margin-bottom: 3px;" class=" span-clear hide btn btn-pn btn-cor-perigo"><i class=" glyphicon glyphicon-remove" style="margin-top: -10px;"></i></a>

                </div>
              </label> 
            </div>

            <div class="col-md-2">

              <label for="formacao">

                  Formação

                  <div class="input-group ">

                      <select id="formacao" name="formacao" data-column="4" class="busca select2_group form-control input-sm">

                          <option value="">Selecione...</option>
                          <option value="Fundamental" @if (old('formacao') == 'Fundamental') selecte="selected" @endif>Fundamental</option>
                          <option value="Médio" @if (old('formacao') == 'Médio') selecte="selected" @endif>Médio</option>
                          <option value="Superior" @if (old('formacao') == 'Superior') selecte="selected" @endif>Superior</option>

                      </select>

                      <a data-column="4" style="margin-right: 0; margin-bottom: 3px;" class=" span-clear hide btn btn-pn btn-cor-perigo"><i class=" glyphicon glyphicon-remove" style="margin-top: -10px;"></i></a>

                  </div>
              </label>  
            </div>

            <div class="col-md-3">
              <label for="atuacao">

                Área de atuação

                <div class="input-group ">
                    <select id="area" name="areas" data-column="5" class="busca select2_group form-control input-sm">
                                
                                <option value="">Selecione...</option>

                                  {{-- Iterar pelar áreas de atuação --}}

                                @foreach($areas as $area)

                                    <option value="{{ $area->descricao }}" @if (old('areas') == $area->id) selected="selected" @endif>{{ $area->descricao }}</option>

                                @endforeach

                    </select>
                    <a data-column="5" style="margin-right: 0; margin-bottom: 3px;" class=" span-clear hide btn btn-pn btn-cor-perigo"><i class=" glyphicon glyphicon-remove" style="margin-top: -10px;"></i></a>

                </div>
              </label>
            </div>

            <div class="col-md-2">
                <label for="indicacao">
                    Indicação

                    <div class="input-group ">

                      <select type="text" id="indicacao" data-column="6" class="busca select2_group form-control input-sm">

                        <option value=""> Selecione... </option>
                        <option value="Sim"> Sim </option>
                        <option value="Não"> Não </option>
                        
                      </select>

                      <a data-column="6" style="margin-right: 0; margin-bottom: 3px;" class=" span-clear hide btn btn-pn btn-cor-perigo"><i class=" glyphicon glyphicon-remove" style="margin-top: -10px;"></i></a>

                    </div>
                </label>
            </div>

            <div class="col-md-2">
              <label for="pcd">
                PCD
                <div class="input-group">
                  <select name="pcd" id="pcd" data-column="7" class="busca select2_group form-control input-sm">
                    <option value=""> Selecione... </option>
                    <option value="Sim"> Sim </option>
                    <option value="Não"> Não </option>
                  </select>
                </div>
              </label>
            </div>
          </div>
      </div>
    </div>

  </div>

	<div class="row curriculo-index">
		
		<div class="col-md-12 col-sm-12 col-xs-12">
          	<div class="x_panel modal-content">
	            <div class="x_title">
	              	<h2>Currículos <small>Utilize os comandos da tabela para reordenar e pesquisar</small></h2>
	              	<div class="clearfix"></div>
	            </div>
            	<div class="x_content">

                  	<table id="datatable" width="100%" class="table table-striped table-bordered">
                      	<thead>
                        	<tr>
                          		<th style="max-width: 265px;">Nome</th>
                          		<th>Idade</th>
                              <th>Sexo</th>
                          		<th>Bairro</th>
                          		<th>Formação</th>
                              <th>Área de Atuação</th>
                              <th>Indicação</th>
                              <th style="max-width: 80px;">PCD</th>
                              <th style="min-width: 65px;">Ações</th>
                        	</tr>
                      	</thead>
                        <tbody>

                          {{-- Tabela preenchida com dataTables Server Side --}}

                        </tbody>
                    </table>

                    {{-- Botão de Encaminhar Currículos --}}

                    <div class="btn-encaminhar">
                      
                      <button class="btn btn-info btn-encaminhar btn-cor-padrao disabled" data-toggle="modal" data-target=".modal-encaminhar"><i class="fa fa-share"></i> Encaminhar Currículo</button>
                      
                      {{-- Botão para selecionar todos currículos --}}
                      
                      <button class="btn btn-info btn-selecionar btn-cor-padrao"><i class="fa fa-check"></i> <span class="acao">Marcar</span> Todos</button>

                    </div>

            	</div>
          	</div>
        </div>
	</div>

  {{-- Modal Excluir --}}

    <div class="modal fade bs-example-modal-sm modal-excluir-curriculo" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Deseja realmente excluir o currículo de <span class="nome"></span> ?</h4>
          </div>
          <div class="modal-body">
            <p>O currículo excluído não poderá ser recuperado posteriormente.</p>
          </div>
          <div class="modal-footer">
            <input type="hidden" value="" id="curriculo_id">
            <button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-danger btn-confirmar-modal">Excluir</button>
          </div>

        </div>
      </div>
    </div>

    {{-- /Modal Excluir --}}

    {{-- Modal Encaminhar --}}

      <div class="modal fade bs-example-modal-sm modal-encaminhar" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Encaminhar Currículos:</h4>
          </div>
          <div class="modal-body">

          <div class="alert alert-success">
            
            <ul id="lista-curriculos">

            </ul>

          </div>

            <div class="form-group">
              <label for="empresa" class="col-md-3">Empresa</label>
              <div class="col-md-9">
                <input type="text" class="form-control col-md-12" name="empresa" id="empresa">
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          
          <div class="modal-footer">

            {{-- Nesta div serão inseridos vários inputs do tipo hidden, um para cada currículo encaminhado --}}

            <div class="curriculos"></div>

            <button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-success btn-confirmar-encaminhamento">Encaminhar</button>
          </div>

        </div>
      </div>
    </div>

    {{-- /Modal Encaminhar --}}

@endsection

@section('js')

	<!-- Datatables -->
    <script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/pdfmake/build/vfs_fonts.js') }}"></script>

    @include("includes.curriculos.index.scripts")

@endsection