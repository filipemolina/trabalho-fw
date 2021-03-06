<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cadastro de Currículos | Login</title>

    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('vendors/animate.css/animate.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('/css/custom.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="logo-login">
          <img src="{{ asset('img/logo-balcao.png') }}" alt="">
        </div>

      <div class="login_wrapper">
        
        <div class="animate form login_form">
          <section class="login_content">
            <form action="{{ route('login') }}" method="post">

              {{ csrf_field() }}

              <h1>Login</h1>
              <div>
                <input id="email" name="email" value="{{ old('email') }}" type="text" class="form-control senha" placeholder="E-mail" required="" />

                  @if ($errors->has('email'))
                      <span class="help-block">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
              </div>
              <div>
                <input type="password" id="password" name="password" class="form-control senha" placeholder="Senha" required="" />

                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif

              </div>

              <div>
                <button type='submit' class="btn btn-default submit" href="index.html"> Entrar </button>
                {{-- <a class="reset_pass" href="#">Lost your password?</a> --}}
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div>
                  {{-- <h1><i class="fa fa-suitcase"></i> Banco de Empregos</h1> --}}
                  <p>©2017 - Subsecretaria da Tecnologia da Informação</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
