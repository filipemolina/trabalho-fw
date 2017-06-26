<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--[if IE]><link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}"><![endif]-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">

    <title>Banco de Empregos | 
      @section('title')


      @show
    </title>

    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"> --}}
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('vendors/iCheck/skins/flat/purple.css') }}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{ asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    {{-- Animate.css --}}
    <link href="{{ asset('vendors/animate.css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('css/custom.min.css') }}" rel="stylesheet">

    @section('css')

    @show

    {{-- Css Customizado --}}

    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{ url('/') }}" class="site_title">
                <img src="{{ asset('/img/logo-balcao.png') }}" alt="">
              </a>
            </div>

            <div class="clearfix"></div>

           <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_info">
                <span>Bem-vindo,</span>
                <h2>{{ Auth::user()->name }}</h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  
                  <li>
                    <a href="{{ url('/') }}">
                      <i class="fa fa-home"></i>Home
                    </a>
                  </li>

                  <li>
                    
                    <a>
                      <i class="fa fa-id-card"></i> Currículos 
                      <span class="fa fa-chevron-down"></span>
                    </a>

                    <ul class="nav child_menu">
                      <li><a href="{{ url('/curriculos') }}">Lista de Currículos</a></li>
                      <li><a href="{{ url('/curriculos/create') }}">Cadastrar Currículos</a></li>

                      {{-- Link para currículos excluídos apenas para o Administrador  --}}
  
                      @if (Auth::user()->is_admin)

                        <li><a href="{{ url('/curriculos-encaminhados') }}"> Encaminhados</a></li>
                        <li><a href="{{ url('/curriculos-excluidos') }}"> Excluídos</a></li>
                        <li><a href="{{ url('/curriculos/relatorios') }}">Relatórios</a></li>

                      @endif

                    </ul>

                  </li>

                  <li>
                    <a>
                      <i class="fa fa-crosshairs"></i> Áreas de Atuação
                      <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/areas') }}">Lista de Áreas</a></li>
                      <li><a href="{{ url('/areas/create') }}">Cadastrar Áreas</a></li>
                    </ul>
                  </li>

                    {{-- Permitir que o usuário veja esses itens do menu apenas se ele for administrador --}}

                    @if (Auth::user()->is_admin)

                        <li>
                          
                          <a>
                            <i class="fa fa-user-circle"></i> Usuários 
                            <span class="fa fa-chevron-down"></span>
                          </a>

                          <ul class="nav child_menu">
                            <li><a href="{{ url('usuarios/') }}">Lista de Usuários</a></li>
                            <li><a href="{{ url('usuarios/create') }}">Cadastrar Usuário</a></li>
                          </ul>

                        </li>

                    @endif


                    <li>
                      <a>
                        <i class="fa fa-bar-chart-o"></i> Opções 
                        <span class="fa fa-chevron-down"></span>
                      </a>

                      <ul class="nav child_menu">
                        <li><a href="{{ url('/configuracoes') }}">Configurações</a></li>
                        
                        <li>

                          <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">  Sair
                          </a>

                          <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                              {{ csrf_field() }}
                          </form>
                          
                        </li>
                      </ul>

                  </li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            {{-- Logotipo Branco --}}

            {{-- <div id="logo-rodape">
              <img src="{{ asset('img/logo-branca.png') }}" alt="">
            </div> --}}
            
          </div>

          

        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>              
            </nav>

            @section('menu-superior')

            @show
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>
                  @section('header-h1')

                  @show
                 </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                {{-- <div class="x_panel home"> --}}
                  {{-- <div class="x_content"> --}}
                      @yield('conteudo')
                  {{-- </div> --}}
                {{-- </div> --}}
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Desenvolvido por <a href="mailto:filipemolina@live.com">Filipe Molina</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
    {{-- Input Mask --}}
    <script src="{{ asset('vendors/jquery.inputmask/dist/jquery.inputmask.bundle.js') }}"></script>
    {{-- iCheck --}}
    <script src="{{ asset('vendors/iCheck/icheck.min.js')  }}"></script>

    @section('js')

    @show

    <!-- Scripts Customizados do Tema -->
    <script src="{{ asset('js/custom.min.js') }}"></script>

    {{-- Scripts Customizados do Projeto--}}
    <script src="{{ asset('js/scripts.js') }}"></script>    
  </body>
</html>
