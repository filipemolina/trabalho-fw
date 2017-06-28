<script>
	
$(function(){

	$("select#ordem_relatorio").change(function(){

		var valor = $(this).val();

		if(valor == "area_atuacao")
		{
			$("#area_atuacao").css('display', 'block').attr('disabled', false);
		}
		else
		{
			$("#area_atuacao").css('display', 'none').attr('disabled', true);			
		}

	});

});

</script>