<script>

      var todos_selecionados = false;
      var tabela;
      var colunas = [];

      function mostrarBotao(seletor, mostrar)
      {
          if(mostrar)
          {
              $(seletor).removeClass("hide").parent().addClass("has-clear");
          }
          else
          {
              $(seletor).addClass("hide").parent().removeClass("has-clear"); 
          }
      }

      /////////////////////////////////////// Iterar por todas as colunas da tabela e mostrar ou esconder os botões de limpar

      function botaoLimpar(table)
      {
          // Mostrar ou não o botão de limpar pesquisa

          var mostrar = false;

          // Iterar pelas colunas

          for (var i = table.length - 1; i >= 0; i--) {

            // Mostrar o termo sendo pesquisado...

            $("input[data-column="+i+"]").val(table[i].search());
            $("select[data-column="+i+"]").val(table[i].search());

            // Caso a pesquisa aplicada à coluna não esteja vazia, mostrar o botão
            
            if(table[i].search() != "")
            {
              // O botão de apagar...

              mostrarBotao(".span-clear[data-column="+i+"]", true);

              // E o botão de apagar geral

              mostrar = true;

              // Tratar a busca por idades separadamente

              if(i == 1)
              {
                var busca_idade = table[i].search();
                busca_idade = busca_idade.replace("^(", "").replace(")$", "").split("|");

                var min = busca_idade[0];
                var max = busca_idade[busca_idade.length - 1];

                if(min == 0)
                {
                    $("#min").val("");

                    mostrarBotao("[data-column=min]", false);
                }
                else
                {
                    $("#min").val(min);

                    mostrarBotao("[data-column=min]", true);
                }

                if(max == 100)
                {
                    $("#max").val("");

                    mostrarBotao("[data-column=max]", false);
                }
                else
                {
                    $("#max").val(max);

                    mostrarBotao("[data-column=max]", true);
                }
              }

            }
            else
            {
              // Esconder o botão de apagar

              // $(".span-clear[data-column="+i+"]").addClass("hide");
              mostrarBotao(".span-clear[data-column="+i+"]", false);

              // Esconder os botões das idades mínima e máxima

              if(i == 1)          
              {
                  mostrarBotao("[data-column=min], [data-column=max]", false);
              }
            }

          }

          // Aplicar a classe hide dependendo da variável "mostrar"

          if(mostrar)
            $(".limpar1").removeClass("hide");
          else
            $(".limpar1").addClass("hide");
      }
      
      $(function(){

        // Ativar o DataTables

        tabela = $('#datatable').DataTable({
          'language' : {
            'url' : '{{ asset('/js/portugues.json') }}'
          },
          processing: true,
          serverSide: true,
          ajax      : "{{ url('/curriculos/tabela') }}",
          columns   : [

            { data : 'nome',       name : 'nome' },
            { data : 'idade',      name : 'idade' },
            { data : 'sexo',       name : 'sexo' },
            { data : 'bairro',     name : 'bairro' },
            { data : 'formacao',   name : 'formacao' },
            { data : 'area',       name : 'area' },
            { data : 'indicacao',  name : 'indicacao' },
            { data : 'encaminhar', name : 'encaminhar' },
            { data : 'acoes',      name : 'acoes' },

          ],
          stateSave: true,
          stateDuration: -1,

          // Implementar a busca avançada serverside

          initComplete : function(){

              // Iterar pelas colunas

              this.api().columns().every(function(){

                  // Popular uma array com todas as colunas da tabela para serem usadas posteriormente
                  // na busca avançada

                  colunas.push(this);

                  // Testar logo no carregamento da tabela se o botão de limpar a pesquisa deve estar ativo

                  botaoLimpar(colunas);

              });

          },
        });

        ///////////////////////////////////////////////////////////////// Busca Avançada

        // Método KeyUp para inputs...

        $("input.busca").keyup(function(){

            // Obter o valor do campo e a coluna à qual ele se refere

            var valor = $(this).val();
            var coluna = $(this).data('column');

            // Chamar a função de busca e redesenho da tabela

            colunas[coluna].search(valor, true, false).draw();

            // Mostrar ou esconder o botão de limpar

            botaoLimpar(colunas);

        });

        // ... E Change para selects.

        $("select.busca").change(function(){

            // Obter o valor do campo e a coluna à qual ele se refere

            var valor = $(this).val();
            var coluna = $(this).data('column');

            // Chamar a função de busca e redesenho da tabela

            colunas[coluna].search(valor, true, false).draw();

            // Mostrar ou esconder o botão de limpar

            botaoLimpar(colunas);

        });

        // Botão de limpar cada campo da busca avançada...

        $("a.span-clear").click(function(e){

            e.preventDefault();

            var coluna = $(this).data('column');

            // Zerar a pesquisa...

            if(coluna == "min" || coluna == "max")
            {
                $("input#"+coluna).val("").trigger("change");
            }
            else
            {
                colunas[coluna].search("", true, false).draw();
            }

            // Reorganizar os botões e os inputs da busca avançada

            botaoLimpar(colunas);

        });

        // E botão para limpar todos os campos

        $("a.limpar1").click(function(e){

            // Iterar pelas colunas da tabela limpando suas pesquisas

            for (var i = colunas.length - 1; i >= 0; i--) {
              colunas[i].search("", true, false);
            }

            // Redesenhar a tabela

            tabela.draw();

            botaoLimpar(colunas);

        });

        // Idades mínima e máxima

        $("#min, #max").change(function(){

            console.log("chamou a função change");

            var min = $("#min").val() ? parseInt($("#min").val()) : 0;
            var max = $("#max").val() ? parseInt($("#max").val()) : 0;

            console.log(min);
            console.log(max);

            var idades = colunas[1];

            var busca = "";

            // Cancelar a execução caso a idade máxima seja menor que a idade mínima

            if(min > max && max != 0) 
            {
              console.log("min > max e max não é 0");

                idades.search("", true, false).draw();

                botaoLimpar(colunas);

                return false;
            }

            // Caso a idade máxima seja 0, executar a pesquisa de "min" até 100

            if(max == 0 && min > 0)
            {
                console.log("max é 0 e min é maior que 0");
                // Criar um vetor com as idades a serem buscadas

                for(i = min; i <= 100; i++)
                {
                  busca = busca + i;

                  if(i < 100)
                    busca = busca+"|";

                }

                // Executar a busca utilizando esse 

                idades.search("^("+ busca + ")$", true, false).draw();

                // Terminar a execuação

                botaoLimpar(colunas)

                return false;
            }

            // Caso a idade mínima seja 0, executar a pesquisa de 0 até max

            if(min == 0 && max > 0)
            {
                console.log("min é 0 e max é maior que 0");
                // Criar um vetor com as idades a serem buscadas

                for(i = 0; i <= max; i++)
                {
                  busca = busca + i;

                  if(i < max)
                    busca = busca+"|";

                }

                // Executar a busca utilizando esse 

                idades.search("^("+ busca + ")$", true, false).draw();

                // Terminar a execuação

                botaoLimpar(colunas)

                return false;
            }

            // Caso as duas variáveis sejam iguais e diferentes de 0, executar a busca usando apenas uma delas

            if(min == max && max != 0)
            {
                console.log("min é igual a max e max não é 0");
                // Criar um vetor com as idades a serem buscadas

                for(i = min; i <= 100; i++)
                {
                  busca = busca + i;

                  if(i < 100)
                    busca = busca+"|";

                }

                // Executar a busca utilizando esse 

                idades.search("^("+ busca + ")$", true, false).draw();

                // Terminar a execuação

                botaoLimpar(colunas)

                return false;
            }

            // Caso as duas variáveis sejam 0

            if(min == max && min == 0)
            {
                console.log("min é igual a max e min é igual a 0");
                idades.search("", true, false).draw();

                botaoLimpar(colunas);

                return false;
            }

            // Execução normal da busca

            if(max > min)
            {
                console.log("max é maior que min");
                // Criar um vetor com as idades a serem buscadas

                for(i = min; i <= max; i++)
                {
                  busca = busca + i;

                  if(i < max)
                    busca = busca+"|";

                }

                // Executar a busca utilizando esse 

                idades.search("^("+ busca + ")$", true, false).draw();

                // Terminar a execuação

                botaoLimpar(colunas)

                return false;

            }

            console.log("não entrou em nada");

        });

        /////////////////////////////////////////////////////////////////// Fim da Busca Avançada

        // Popular o modal com as informações do currículo à ser excluído

        $('body').on('click', '.btn-excluir', function(){

          var nome = $(this).data('nome');

          // Definir o valor do campo hidden "curriculo_id" que será usando quando o usuário
          // confirmar a exclusão no modal

          $("#curriculo_id").val($(this).data('id'));

          $('.modal-content span.nome').html(nome);

        });

        // Excluir o currículo quando o usuário confirmar no modal

        $('.btn-confirmar-modal').click(function(){

          var id = $("#curriculo_id").val();

          // Enviar a requisição DELETE para o Laravel, caso positivo

          $.post("{{ url('curriculos/') }}/"+id, {
            _token  : "{{ csrf_token() }}",
            _method : 'DELETE',
            id : id
          }, function(data){

            // window.location = "{{ url('curriculos/') }}";

            $("a.btn-excluir[data-id="+id+"]").parents('tr').remove();

            $(".modal-excluir-curriculo").modal('hide');

          });

        });

        // Evitar que o botão "Encaminhar currículos" continue abrindo o modal
        // mesmo quando estiver desabilitado

        $("button.btn-encaminhar").click(function(e){

          if($(this).hasClass('disabled'))
            e.stopPropagation();

        });

        // Popular o Modal com as informações do currículo à ser ENCAMINHADO

        // Esse evento é disparado pela biblioteca iCheck, inputs com iCheck não
        // disparam eventos padrão (infelizmente)

        $('input.chk-encaminhar').on('ifChanged',function(){

            // Toda vez que um checkbox for clicado, iterar por todos os checkboxes exibidos,
            // apagar a lista de currículos no modal e então incluir apenas os nomes dos currículos
            // selecionados

            // Apagar todas as LI's

            $("ul#lista-curriculos").empty();

            // Apagar todos os campos hidden

            $("div.modal-footer .curriculos").empty();

            // Iterar pelos checkboxes clicados

            $("input.chk-encaminhar:checked").each(function(index, element){

                var nome = $(element).data('nome');
                var id = $(element).data('id');

                //Adicionar o nome à lista

                $("ul#lista-curriculos").append($('<li>').html(nome));

                // Adicionar o ID aos campos hidden

                $("<input>").attr('type', 'hidden').attr('name', 'ids[]').val(id).appendTo('div.modal-footer .curriculos');

            });

            // Abilitar ou desabilitar o botão de encaminhar

            if(!$("input.chk-encaminhar:checked").length)

              $("button.btn-encaminhar").addClass('disabled');

            else

              $("button.btn-encaminhar").removeClass('disabled');

        });

        // Enviar a requsição POST para /curriculos/encaminhar quando o botão do modal for clicado

        $("button.btn-confirmar-encaminhamento").click(function(){

            var ids = [];
            var empresa = $("input#empresa").val();

            $("input.chk-encaminhar:checked").each(function(index, value){

                ids.push($(value).data('id'));

            });

            // Enviar a requisição

            $.post('{{ url('/curriculos/encaminhar') }}', {
              _token  : "{{ csrf_token() }}",
              ids     : ids,
              empresa : empresa,
            }, function(data){

              $(".modal-encaminhar").modal('toggle');
              $("input#empresa").val("");

            })

        });

        // Selecionar ou apagar todos os checkboxes

        $("button.btn-selecionar").click(function(){

            if(!todos_selecionados){

              $("input.chk-encaminhar").iCheck('check');

              $("button.btn-selecionar i").removeClass('fa-check').addClass('fa-times');

              $("button.btn-selecionar .acao").html("Desmarcar");

              todos_selecionados = true;

            }
            else
            {

              $("input.chk-encaminhar").iCheck('uncheck');

              $("button.btn-selecionar i").removeClass('fa-times').addClass('fa-check');

              $("button.btn-selecionar .acao").html("Marcar");

              todos_selecionados = false;

            }

              

        });

      });

      // Limpar campo 
      $(document).on("click", ".limpar1", function(e){

          e.preventDefault();

          $(this).parent().parent().parent().parent().find("input, select").val('');

      });
      
    </script>