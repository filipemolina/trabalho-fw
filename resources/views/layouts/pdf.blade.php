<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Currículo</title>
    
    <link rel="stylesheet" href=" {{ url("css/pdf.css") }}">

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

    </style>

      <!-- Font Awesome -->
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    
  </head>
  <body>
    
    <!-- Conteúdo -->
	@yield('conteudo')

  </body>
</html>