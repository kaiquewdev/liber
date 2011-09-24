$(function() {
	$(".datepicker").datetimepicker({
		showOn: "button",
		buttonImage: "../img/calendario_icone.gif",
		buttonImageOnly: true
	});
		
	$('#servico_ordem_abas').tabs();
	
	//pesquisa cliente
	$("#ServicoOrdemClienteId").autocomplete({
		source: "pesquisaAjaxCliente/",
		minLength: 3,
		select: function(event, ui) {
			$("#ServicoOrdemClienteId").val(ui.item.codigo);
		}
	});
	
	//a partir daqui refere-se a aba de Serviços
	$("#ServicoNome").autocomplete({
		source: "pesquisaAjaxServico/nome",
		minLength: 3,
		select: function(event, ui) {
			$("#ServicoId").val(ui.item.id);
			$('#ServicoValor').val(ui.item.valor);
			$('#ServicoQuantidade').focus();
		}
	});
	
	$('.remover_linha').live('click',function(evento){
		//passo a referencia da linha da tabela
		remover_linha($(this).parent().parent());
	});
	
	$('#ServicoId').blur(function(){
		procurar_por_codigo($(this).val());
	});
	
	$('#servicos_pesquisar').bind('keypress', function(e){
		if ( e.keyCode == 13 ) {
			e.preventDefault();
			adicionar_servico();
		}
	});

	
});

function procurar_por_codigo(codigo) {
	if (codigo == null || codigo == '') return null;
	
	$(function(){
		
		$.getJSON('pesquisaAjaxServico/codigo', {'term': codigo}, function(data) {
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
		
		numero_campo = $('#numero_itens_incluidos').val();
		
		novo_campo = $('<tr>'+
		'<td><input type="text" class="noinput item_id" name="data[ServicoOrdemItem]['+numero_campo+'][servico_id]" value="'+id+'" /></td>'+
		'<td><input type="text" class="noinput item_nome" value="'+nome+'" /></td>'+
		'<td><input type="text" class="noinput item_qtd" name="data[ServicoOrdemItem]['+numero_campo+'][quantidade" value="'+quantidade+'" /></td>'+
		'<td><input type="text" class="noinput item_val" name="data[ServicoOrdemItem]['+numero_campo+'][valor]" value="'+valor+'" /></td>'+
		'<td><img src="../img/del24x24.png" class="remover_linha"/></td>'+
		'</tr>');
		novo_campo.insertAfter($('#servicos_incluidos tr:last'));
		$('#numero_itens_incluidos').val(numero_campo+1);
		
		valor_total = sub_vir_ponto($('#valor_total').html());
		valor_total = parseFloat(valor_total);
		valor_total += quantidade * (sub_vir_ponto(valor));
		valor_total = arredonda_float(valor_total);
		$('#valor_total').html(sub_ponto_vir(valor_total));
		
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
		
		valor_total = sub_vir_ponto($('#valor_total').html());
		valor_total = parseFloat(valor_total);
		valor_total -= quantidade * (sub_vir_ponto(valor));
		valor_total = arredonda_float(valor_total);
		
		if (valor_total == 0) {
			$('#valor_total').html('0,0');
		}
		else {
			$('#valor_total').html(sub_ponto_vir(valor_total));
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