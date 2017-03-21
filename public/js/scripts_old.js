////////////////////////////////////////// Funções Gerais

// Serializar os dados de um formulário em um vetor associativo

function serializar(form)
{
	var valores = {};

	$.each($(form).serializeArray(), function(i, campo) {
	    valores[campo.name] = campo.value;
	});

	return valores;
}

// Formatar data vinda do banco de dados

function formatarData(data)
{
	// Elementos = Array com Ano, Mes, Dia

	 var elementos = data.split(" ")[0].split("-");

	 return elementos[2] + "/" + elementos[1] + "/" + elementos[0][2]+elementos[0][3];
}

// Atividades que devem ser executadas após o cadastramento de um carro

function processarCarro()
{
	var alerta = mostrarAlert({
		classe   : 'success',
		titulo   : 'Parabéns:',
		mensagem : 'Carro cadastrado com sucesso! Insira agora os dados do atendimento.'
	});

	$(".x_content").prepend(alerta);

	// Mudar o Texto do Título do Form

	$("div.x_title h2").html('Dados do Atendimento');

	// Remover o form da tela e mostrar o form de atendimento

	$("form#form-cadastrar-carro").addClass('animated fadeOutLeft');

	// Continuar após a animação terminar

	$('form#form-cadastrar-carro').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){

		$('form#form-cadastrar-carro').addClass("hidden");

		$("form#form-cadastrar-atendimento").removeClass("hidden").addClass('animated fadeInRight');

		// Apagar os dados do formulário

		$("form.form-ajax")[0].reset();

	});
}

// Atividades que devem ser executadas após o cadastramento de um atendimento

function processarAtendimento()
{
	var alerta = mostrarAlert({
		classe   : 'success',
		titulo   : 'Parabéns:',
		mensagem : 'O Atendimento foi cadastrado com sucesso.'
	});

	$(".x_content").prepend(alerta);

	$("#form-cadastrar-atendimento").addClass("fadeOutLeft");

	$('form#form-cadastrar-carro').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){

		$("#form-cadastrar-atendimento").addClass("hidden");

		$("div.row.final").removeClass("hidden").addClass("animated fadeInRight");

	});
}

// Criar o bloco de resultados da busca da página inicial

function criarBloco(carro)
{

	// Obter o template
	
	var template = $("script#resultado-busca").html();

	// Compilar o template

	var compilar = Handlebars.compile(template);

	// Formatar a data de cada atendimento vinda do banco de dados

	for (var i = carro.atendimentos.length - 1; i >= 0; i--) {

		// Criar a propriedade "criado", apenas para exibição, com o valor retornado
		// da função formatarData()
		
		carro.atendimentos[i].criado = formatarData(carro.atendimentos[i].created_at);

	}

	// Jogar os dados no template

	var html = compilar(carro);

	// Retornar o HTML gerado;

	return html;
}

// Criar o HTML de um alert

function mostrarAlert(dados)
{
	var template = $("script#alert").html();
	var compilar = Handlebars.compile(template);
	var html = compilar(dados);
	return html;

}

///////////////////////////////////////////////////////// Funções executadas após o carregamento da página

$(function(){

	//////////////////////////////////////////////// Habilitar as máscaras de input

	$(":input").inputmask();

	$("input#busca").inputmask('AAA-9999');

	//////////////////////////////////////////////// Busca via Ajax dos carros por placa.
	//////////////////////////////////////////////// Busca principal do Site

	$("button#btn_busca").click(function(){

		// Apagar a div de mensagem inicial

		$("div.inicial").css('display', 'none');

		// Obter o termo de busca

		var termo = $("input#busca").val().toUpperCase();

		// Obter o token CSRF (medida de segurança do Laravel)

		var token = $("input[name=_token").val();

		// Limpar a tela dos resultados anteriores

		$("div.row.resultados").empty();

		// Mostrar imagem de Loading

		$("img#img-loading").css('display', 'block');

		///////////////////////////////////////////// Request Ajax

		$.post('/busca', { termo : termo, _token : token }, function(data){

			console.log("Chamou");

			// Converter o resultado em um objeto JSON

			var resultado = JSON.parse(data);

			console.log(resultado);

			// Apagar a imagem de Loading e a pasta vazia

			$("img#img-loading, div.vazio").css('display', 'none');

			// Testar se houve algum resultado para a pesquisa

			if(resultado.length > 0)
			{
				// Iterar pelos resultados e montar os blocos

				for (var i = resultado.length - 1; i >= 0; i--) {
					
					// Chamar a função que cria o bloco para cada resultado

					$("div.row.resultados").append(criarBloco(resultado[i]));

				}
			}
			else
			{
				$("div.vazio").css('display', 'block');
			}

		});

	});

	//////////////////////////////////////////////// Ativar a busca ao apertar ENTER no input de busca

	$("input#busca").keyup(function(event){
	    if(event.keyCode == 13){
	        $("button#btn_busca").click();
	    }
	});

	//////////////////////////////////////////////// Evitar que os formulários da classe "form-ajax" sejam enviados de
	//////////////////////////////////////////////// forma tradicional.

	$("form.form-ajax").submit(function(e){

		e.preventDefault();

		// Apagar os avisos que já tenham sido mostrados para o usuário

		$(".x_content .alert").remove();

		// Obter o action do formulário que disparou o evento

		var url = $(this).attr('action');

		// Transformar os dados do formulário em um vetor associativo

		var valores = serializar($(this));

		// Caso seja o cadastro de um carro, transformar a placa para Uppercase

		if(valores.model == 'carro')
			valores.placa = valores.placa.toUpperCase();

		// Enviar a request ajax para cadastrar o carro

		$.post(url, valores, function(data){

			// Caso seja o formulário de cadastrar carros

			if(valores.model == 'carro')
			{
				processarCarro();
				var dados = JSON.parse(JSON.parse(data));
				$("input#carro_id").val(dados.id);
			}

			// Caso seja o formulário de cadastrar atendimentos

			if(valores.model == 'atendimento')
			{
				processarAtendimento();
			}

		}).fail(function(data){
			
			var erros = JSON.parse(data.responseText);

			// Mostrar o alert com as mensagens de erro
			// Iterar por todas as propriedades do objeto "erros"

			for(var propriedade in erros)
			{
				if(erros.hasOwnProperty(propriedade))
				{
					// Obter o HTML do alerta

					var alerta = mostrarAlert({
						classe   : 'error',
						titulo   : 'Atenção:',
						mensagem : erros[propriedade][0]
					});

					// Colocar o alerta no topo do formulário

					$(".x_content").prepend(alerta);

				}
			}

		});

		return false;

	});
});