$(function() {
	
	$('.remover_linha').live('click',function(evento){
		//passo a referencia a linha da tabela
		remover_linha($(this).parent().parent());
	});

	$('#parcelas_inserir input').bind('keypress', function(e){
		if ( e.keyCode == 13 ) {
			e.preventDefault();
			adicionar_parcela();
		}
	});
	
	// verificacoes ao submeter o formulario
	$('input[type="submit"]').click(function(){
		registro = 0;
		$('#parcelas_inseridas tr').each(function() {
			registro++;
		});
		if (registro < 1) {
			alert('É necessário incluir ao menos uma parcela!');
			return false;
		} 
	});
	
});

function adicionar_parcela() {
	$(function() {
		dias = $('#PesquisaFormaPagamentoItemDiasIntervaloParcela').val();
		
		if ( (dias == '') ) {
			alert ('Há campos não preenchidos!');
			return false;
		}
		
		if ( ! eh_inteiro(dias) ) {
			alert ('Número de dias inválido!');
			return false;
		}
		
		numero_campo = parseInt($('#numero_itens_incluidos').val());
		
		novo_campo =
		'<tr>'+
			'<td> <input name="none" value="'+parseInt(numero_campo+1)+'" class="noinput" /> </td>' +
			'<td> <input type="text" name="data[FormaPagamentoItem]['+numero_campo+'][dias_intervalo_parcela]" value="'+dias+'" class="noinput dias_intervalo_parcela" /> </td>'+
			'<td> <img src="'+raiz_site+'/img/del24x24.png" class="remover_linha"/> </td>'+
		'</tr>'+"\n";
		
		$('#parcelas_inseridas').append(novo_campo);
		$('#numero_itens_incluidos').val(numero_campo+1);
		
		limpar_pesquisa();
		$('#PesquisaFormaPagamentoItemDiasIntervaloParcela').focus();
	});
}

// recebe a linha como referencia
function remover_linha(objeto_jquery) {
	$(function() {
		objeto_jquery.remove();
	});
}

function limpar_pesquisa() {
	$(function() {
		$('#parcelas_inserir input').each(function() {
			$(this).val('');
		});
	});
}
