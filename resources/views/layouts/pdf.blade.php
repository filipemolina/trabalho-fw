<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Relatório</title>
    
    <link rel="stylesheet" href="{{ url("css/pdf.css") }}">

    <style>
    	
    	table.page
		{
		    page-break-after: always;
		    page-break-inside: avoid;
		}

		page[size="A4"] {  
		  width: 21cm;
		  height: 29.7cm; 
		}

    @media screen
    {

      body{
            width: 21cm;
            min-height: 29.7cm;
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

    }

    @media print
    {
      th, th td { background: #3D276B !important; }
    }

    </style>

      <!-- Font Awesome -->
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    
  </head>
  <body>
    
    <!-- Conteúdo -->
	@yield('conteudo')

  </body>
</html>