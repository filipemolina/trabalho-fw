<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Currículo</title>
    
    <link rel="stylesheet" href="css/pdf.css">

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

  </head>
  <body>
    
    <!-- Conteúdo -->
	@yield('conteudo')

  </body>
</html>