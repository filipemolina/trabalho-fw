<script>

      var todos_selecionados = false;

      var colunas = [];

       /* Função para incluir a busca pelos campos de Idade Mínima e Máxima */
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = parseInt( $('#min').val(), 10 );
                var max = parseInt( $('#max').val(), 10 );
                var age = parseFloat( data[1] ) || 0; // use data for the age column

                console.log(min);
                console.log(max);
                console.log(age);
                console.log(data[1]);
         
                if ( ( isNaN( min ) && isNaN( max ) ) ||
                     ( isNaN( min ) && age <= max ) ||
                     ( min <= age   && isNaN( max ) ) ||
                     ( min <= age   && age <= max ) )
                {
                    return true;
                }
                return false;
            }
        );
      
      $(function(){

        // Ativar o DataTables

        var table = $('#datatable').DataTable({
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

              });

          },
        });

        ///////////////////////////////////////////////////////////////// Busca Avançada

        $(".busca").change(function(){

            // Obter o valor do campo e a coluna à qual ele se refere

            var valor = $(this).val();
            var coluna = $(this).data('column');

            console.log(valor);
            console.log(coluna);

            // Chamar a função de busca e redesenho da tabela

            colunas[coluna].search(valor, true, false).draw();

        });

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

      $('.has-clear input, .has-clear select').on('change propertychange', function() {
          var $this = $(this);
          var visible = Boolean($this.val());
          $this.siblings('.span-clear').toggleClass('hidden', !visible);
      }).trigger('propertychange');

      $('.span-clear').click(function() {
          $(this).siblings('input, select').val('')
          .trigger('propertychange').focus();
      });

      // Limpar campo 
      $(document).on("click", ".limpar1", function(e){

          e.preventDefault();

          $(this).parent().parent().parent().parent().find("input, select").val('');

      });
      
    </script>