$(function() {

	$(".datepicker").datetimepicker({
		showOn: "button",
		buttonImage: raiz_site+"/img/calendario_icone.gif",
		buttonImageOnly: true
	});
		
	$('#servico_ordem_abas').tabs();
	
	$('#ServicoValor').priceFormat();
	$('#ServicoOrdemCustoOutros').priceFormat();
	$('#ServicoOrdemDesconto').priceFormat();
	
	//pesquisa cliente
	//autocomplete
	$("#pesquisar_cliente").autocomplete({
		source: ajaxPesqCliente + "nome",
		minLength: 3,
		select: function(event, ui) {
			if (ui.item.bloqueado) {
				alert ('Cliente está bloqueado!');
				$('#pesquisar_cliente').val('');
				$("#ServicoOrdemClienteId").val('');
				event.preventDefault();
				return null;
			}
			if (ui.item.inativo) {
				alert ('Cliente está inativo!');
				$('#pesquisar_cliente').val('');
				$("#ServicoOrdemClienteId").val('');
				event.preventDefault();
				return null;
			}
			$("#ServicoOrdemClienteId").val(ui.item.id);
			$('#pesquisar_cliente').val(ui.item.nome);
		}
	});
	// ao digitar o codigo
	$('#ServicoOrdemClienteId').blur(function(){
		codigo = $(this).val();
		if (codigo == null || codigo == '') return null;
		$.getJSON(ajaxPesqCliente + 'codigo', {'term': codigo}, function(data) {
			if (data == null) {
				alert ('Cliente com o código '+codigo+' não foi encontrado!');
				$('#pesquisar_cliente').val('');
				$("#ServicoOrdemClienteId")
					.val('')
					.focus();
			}
			else { //encontrou resultados
				data = data[0];
				if (data.bloqueado) {
					alert ('Cliente está bloqueado!');
					$('#pesquisar_cliente').val('');
					$("#ServicoOrdemClienteId").val('')
					return null;
				}
				if (data.inativo) {
					alert ('Cliente está inativo!');
					$('#pesquisar_cliente').val('');
					$("#ServicoOrdemClienteId").val('')
					return null;
				}
				$("#ServicoOrdemClienteId").val(data.id);
				$('#pesquisar_cliente').val(data.nome);
			}
		});
	});
	
	//a partir daqui refere-se a aba de Serviços
	$("#ServicoNome").autocomplete({
		source: ajaxPesqServico + "nome",
		minLength: 3,
		select: function(event, ui) {
			$("#ServicoId").val(ui.item.id);
			$('#ServicoValor').val(ui.item.valor);
			$('#ServicoQuantidade').focus();
		}
	});
	
	$('.remover_linha').live('click',function(evento){
		//passo a referencia a linha da tabela
		remover_linha($(this).parent().parent());
	});
	
	$('#ServicoId').blur(function(){
		procurar_por_codigo($(this).val());
	});
	
	$('#servicos_pesquisar input').bind('keypress', function(e){
		if ( e.keyCode == 13 ) {
			e.preventDefault();
			adicionar_servico();
		}
	});
	
	// verificacoes ao submeter o formulario
	$('input[type="submit"]').click(function(){
		registro = 0;
		$('#servicos_incluidos tr').each(function() {
			registro++;
		});
		if (registro < 1) {
			alert('É necessário incluir ao menos um serviço!');
			return false;
		} 
	});
	
});

function procurar_por_codigo(codigo) {
	if (codigo == null || codigo == '') return null;
	
	$(function(){
		
		$.getJSON( ajaxPesqServico + 'codigo', {'term': codigo}, function(data) {
			if (data == null) {
				alert ('Serviço com o código '+codigo+' não foi encontrado!');
				$('#ServicoNome').val('');
				$('#ServicoValor').val('');
				$('#ServicoQuantidade').val('');
				$('#ServicoId')
					.val('')
					.focus();
				return false;
			}
			else {
				data = data[0];
				$('#ServicoId').val(data.id);
				$('#ServicoNome').val(data.label);
				$('#ServicoValor').val(data.valor);
				$('#ServicoQuantidade').focus();
			}
		});
		
	});
}

function adicionar_servico() {
	$(function() {
		id = $('#ServicoId').val();
		nome = $('#ServicoNome').val();
		quantidade = $('#ServicoQuantidade').val();
		valor = $('#ServicoValor').val();
		
		if ( (id == '') || (nome == '') || (quantidade == '') || (valor == '') ) {
			alert ('Há campos não preenchidos!');
			return false;
		}
		
		campo_alerta = null;
		if ( ! eh_inteiro(id) ) campo_alerta = 'código';
		else if (! eh_inteiro(quantidade) ) campo_alerta = 'quantidade';
		if (campo_alerta != null) {
			alert ('O campo '+campo_alerta+' não é um número inteiro!');
			return false;
		}
		
		//se o item já foi inserido, removo o que havia
		$('#servicos_incluidos tr').each(function() {
			v = $(this).find('.item_id').val();
			if ( v == id ) {
				remover_linha($(this));
			}
		});
		
		numero_campo = parseInt($('#numero_itens_incluidos').val());
		
		novo_campo =
		'<tr>'+
			'<td> <input type="text" name="data[ServicoOrdemItem]['+numero_campo+'][servico_id]" value="'+id+'" class="noinput item_id" /> </td>'+
			'<td> <input type="text" name="data[ServicoOrdemItem]['+numero_campo+'][servico_nome]" value="'+nome+'" class="noinput item_nome" /> </td>'+
			'<td> <input type="text" name="data[ServicoOrdemItem]['+numero_campo+'][quantidade]" value="'+quantidade+'" class="noinput item_qtd" /> </td>'+
			'<td> <input type="text" name="data[ServicoOrdemItem]['+numero_campo+'][valor]" value="'+valor+'" class="noinput item_val" /> </td>'+
			'<td> <img src="../img/del24x24.png" class="remover_linha"/> </td>'+
		'</tr>'+"\n";
		
		$('#servicos_incluidos').append(novo_campo);
		$('#numero_itens_incluidos').val(numero_campo+1);
		
		valor_total = moeda2numero($('#valor_total').html());
		valor_total = parseFloat(valor_total);
		valor_total += quantidade * (moeda2numero(valor));
		valor_total = arredonda_float(valor_total);
		$('#valor_total').html(numero2moeda(valor_total));
		
		limpar_pesquisa();
		$('#ServicoId').focus();
	});
}

function remover_linha(objeto_jquery) {
	$(function() {
		linha = objeto_jquery;
		id = linha.find('.item_id').val();
		nome = linha.find('.item_nome').val();
		quantidade = linha.find('.item_qtd').val();
		valor = linha.find('.item_val').val();
		
		valor_total = moeda2numero($('#valor_total').html());
		valor_total = parseFloat(valor_total);
		valor_total -= quantidade * (moeda2numero(valor));
		valor_total = arredonda_float(valor_total);
		
		if (valor_total == 0) {
			$('#valor_total').html('0,0');
		}
		else {
			$('#valor_total').html(numero2moeda(valor_total));
		}
		
		linha.remove();
	});
}

function limpar_pesquisa() {
	$(function() {
		$('#servicos_pesquisar input').each(function() {
			$(this).val('');
		});
	});
}
