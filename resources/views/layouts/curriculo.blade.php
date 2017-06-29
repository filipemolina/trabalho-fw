<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Currículo</title>
    
    <link rel="stylesheet" href="css/pdf.css">

    <style>
      
        body{
            width: 21cm;
            margin: 0 auto;
            background-color: #fff;
            padding: 2cm;
            -webkit-box-shadow: 7px 3px 23px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 7px 3px 23px 0px rgba(0,0,0,0.75);
            box-shadow: 7px 3px 23px 0px rgba(0,0,0,0.75);
            color: black;
            margin-top: 1cm;
            margin-bottom: 1cm;
        }

        html { background-color: #ccc; }

        td, th { border: 1px solid black; }

    </style>
    
  </head>
  <body>
    
    <!-- Conteúdo -->
	 @yield('conteudo')

  </body>
</html>