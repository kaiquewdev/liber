$(function() {

	$(".datepicker").datepicker({
		showOn: "button",
		buttonImage: raiz_site+"/img/calendario_icone.gif",
		buttonImageOnly: true
	});
		
	$('#pedido_venda_abas').tabs();
	
	$('#PedidoVendaDesconto').priceFormat();
	$('#ProdutoPrecoVenda').priceFormat();
	$('#PedidoVendaCustoFrete').priceFormat();
	$('#PedidoVendaCustoSeguro').priceFormat();
	$('#PedidoVendaCustoOutros').priceFormat();
	
	data = new Date();
	data_fim = data.getDate()+'/'+(data.getMonth()+1)+'/'+data.getFullYear();
	if ($('#PedidoVendaDataVenda').val() == '') {
		$('#PedidoVendaDataVenda').val(data_fim);
	}
	
	$('#PedidoVendaFormaPagamentoId').change(function(){
		$('.numeroparcelas').remove();
		id = $(this).val();
		$.getJSON(ajaxPesqFormaPagamento, {'id': id}, function(data) {
			if (data == null) {
				alert ('Forma de pagamento '+id+' não foi encontrada!');
			}
			else { //encontrou resultados
				
				if (data.numero_maximo_parcelas > 0) {
					var opcoes='';
					for (i=1;i<=data.numero_maximo_parcelas;i++) {
						opcoes+= '<option value='+i+'>'+i+'</option>';
					}
					html = '<select id="ReceberContaNumeroParcelas" name="data[ReceberConta][numero_parcelas]" class="numeroparcelas">\n\
							'+opcoes+'\n\
							</select>';
				}
				else {
					html = '<select id="ReceberContaNumeroParcelas" name="data[ReceberConta][numero_parcelas]" class="numeroparcelas">\n\
								<option value=""></option>\n\
							</select>';
				}
				$('label[for="ReceberContaNumeroParcelas"]').after(html);
			}
		});
	});
	
	//pesquisa cliente
	//autocomplete
	$("#pesquisar_cliente").autocomplete({
		source: ajaxPesqCliente + "nome",
		minLength: 3,
		select: function(event, ui) {
			if (ui.item.bloqueado) {
				alert ('Cliente está bloqueado!');
				$('#pesquisar_cliente').val('');
				$("#PedidoVendaClienteId").val('');
				event.preventDefault();
				return null;
			}
			if (ui.item.inativo) {
				alert ('Cliente está inativo!');
				$('#pesquisar_cliente').val('');
				$("#PedidoVendaClienteId").val('');
				event.preventDefault();
				return null;
			}
			$("#PedidoVendaClienteId").val(ui.item.id);
			$('#pesquisar_cliente').val(ui.item.nome);
		}
	});
	// ao digitar o codigo
	$('#PedidoVendaClienteId').blur(function(){
		codigo = $(this).val();
		if (codigo == null || codigo == '') return null;
		$.getJSON(ajaxPesqCliente + 'codigo', {'term': codigo}, function(data) {
			if (data == null) {
				alert ('Cliente com o código '+codigo+' não foi encontrado!');
				$('#pesquisar_cliente').val('');
				$("#PedidoVendaClienteId")
					.val('')
					.focus();
			}
			else { //encontrou resultados
				data = data[0];
				if (data.bloqueado) {
					alert ('Cliente está bloqueado!');
					$('#pesquisar_cliente').val('');
					$("#PedidoVendaClienteId").val('')
					return null;
				}
				if (data.inativo) {
					alert ('Cliente está inativo!');
					$('#pesquisar_cliente').val('');
					$("#PedidoVendaClienteId").val('')
					return null;
				}
				$("#PedidoVendaClienteId").val(data.id);
				$('#pesquisar_cliente').val(data.nome);
			}
		});
	});
	
	//a partir daqui refere-se a aba de produtos
	$("#ProdutoNome").autocomplete({
		source: ajaxPesqProduto + "nome",
		minLength: 3,
		select: function(event, ui) {
			if (ui.item.fora_de_linha) {
				alert ('Produto '+ui.item.id+' está fora de linha!');
				$('#ProdutoNome').val('');
				$('#ProdutoPrecoVenda').val('');
				$('#ProdutoQuantidade').val('');
				$('#ProdutoQuantidadeEstoque').val('');
				$('#ProdutoId')
				.val('')
				.focus();
				return false;
			}
			if (! ui.item.eh_vendido) {
				alert ('O tipo do produto '+ui.item.id+' impede que seja vendido!');
				$('#ProdutoNome').val('');
				$('#ProdutoPrecoVenda').val('');
				$('#ProdutoQuantidade').val('');
				$('#ProdutoQuantidadeEstoque').val('');
				$('#ProdutoId')
				.val('')
				.focus();
				return false;
			}
			if (ui.item.tem_estoque_ilimitado == 0) {
				if (ui.item.estoque_disponivel <= 0) {
					alert ('Produto '+ui.item.id+' não está disponível em estoque!');
					return false;
				}
				else $('#ProdutoQuantidadeEstoque').val(ui.item.estoque_disponivel);
			}
			else $('#ProdutoQuantidadeEstoque').val('ilimitado');
			$("#ProdutoId").val(ui.item.id);
			$('#ProdutoPrecoVenda').val(ui.item.preco_venda);
			$('#preco_custo').val(ui.item.preco_custo);
			$('#ProdutoQuantidade').focus();
		}
	});
	
	$('.remover_linha').live('click',function(evento){
		//passo a referencia a linha da tabela
		remover_linha($(this).parent().parent());
	});
	
	$('#ProdutoId').blur(function(){
		procurar_por_codigo($(this).val());
	});
	
	$('#produtos_pesquisar input').bind('keypress', function(e){
		if ( e.keyCode == 13 ) {
			e.preventDefault();
			adicionar_produto();
		}
	});
	
	// verificacoes ao submeter o formulario
	$('input[type="submit"]').click(function(){
		registro = 0;
		$('#produtos_incluidos tr').each(function() {
			registro++;
		});
		if (registro < 1) {
			alert('É necessário incluir ao menos um produto!');
			return false;
		}
		
	});
	
});

function procurar_por_codigo(codigo) {
	if (codigo == null || codigo == '') return null;
	
	$(function(){
		
		$.getJSON( ajaxPesqProduto + 'codigo', {'term': codigo}, function(data) {
			if (data == null) {
				alert ('Produto com o código '+codigo+' não foi encontrado!');
				$('#ProdutoNome').val('');
				$('#ProdutoPrecoVenda').val('');
				$('#ProdutoQuantidade').val('');
				$('#ProdutoQuantidadeEstoque').val('');
				$('#ProdutoId')
					.val('')
					.focus();
				return false;
			}
			else {
				data = data[0];
				if (data.fora_de_linha) {
					alert ('Produto '+codigo+' está fora de linha!');
					$('#ProdutoNome').val('');
					$('#ProdutoPrecoVenda').val('');
					$('#ProdutoQuantidade').val('');
					$('#ProdutoQuantidadeEstoque').val('');
					$('#ProdutoId')
					.val('')
					.focus();
					return false;
				}
				if (! data.eh_vendido) {
					alert ('O tipo do produto '+codigo+' impede que seja vendido!');
					$('#ProdutoNome').val('');
					$('#ProdutoPrecoVenda').val('');
					$('#ProdutoQuantidade').val('');
					$('#ProdutoQuantidadeEstoque').val('');
					$('#ProdutoId')
					.val('')
					.focus();
					return false;
				}
				if (data.tem_estoque_ilimitado == 0) {
					if (data.estoque_disponivel <= 0) {
						alert ('Produto '+codigo+' não está disponível em estoque!');
						return false;
					}
					else $('#ProdutoQuantidadeEstoque').val(data.estoque_disponivel);
				}
				else $('#ProdutoQuantidadeEstoque').val('ilimitado');
				
				
				$('#ProdutoId').val(data.id);
				$('#ProdutoNome').val(data.label);
				$('#ProdutoPrecoVenda').val(data.preco_venda);
				$('#preco_custo').val(data.preco_custo);
				$('#ProdutoQuantidade').focus();
			}
		});
		
	});
}

function adicionar_produto() {
	$(function() {
		id = $('#ProdutoId').val();
		nome = $('#ProdutoNome').val();
		quantidade = $('#ProdutoQuantidade').val();
		valor = $('#ProdutoPrecoVenda').val();
		quantidade_estoque = $('#ProdutoQuantidadeEstoque').val();
		preco_custo = $('#preco_custo').val();
		
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
		
		if (quantidade_estoque != 'ilimitado') {
			if (quantidade > quantidade_estoque) {
				alert ('A quantidade disponível do produto é menor do que a inserida!');
				return false;
			}
		}
		
		if (valor < preco_custo) {
			alert ('O preço de venda é menor que o preço de custo!');
			return false;
		}
		
		//se o item já foi inserido, removo o que havia
		$('#produtos_incluidos tr').each(function() {
			v = $(this).find('.item_id').val();
			if ( v == id ) {
				remover_linha($(this));
			}
		});
		
		numero_campo = parseInt($('#numero_itens_incluidos').val());
		
		novo_campo =
		'<tr>'+
			'<td> <input type="text" name="data[PedidoVendaItem]['+numero_campo+'][produto_id]" value="'+id+'" class="noinput item_id" /> </td>'+
			'<td> <input type="text" name="data[PedidoVendaItem]['+numero_campo+'][produto_nome]" value="'+nome+'" class="noinput item_nome" /> </td>'+
			'<td> <input type="text" name="data[PedidoVendaItem]['+numero_campo+'][quantidade]" value="'+quantidade+'" class="noinput item_qtd" /> </td>'+
			'<td> <input type="text" name="data[PedidoVendaItem]['+numero_campo+'][preco_venda]" value="'+valor+'" class="noinput item_val" /> </td>'+
			'<td> <img src="'+raiz_site+'/img/del24x24.png" class="remover_linha"/> </td>'+
		'</tr>'+"\n";
		
		$('#produtos_incluidos').append(novo_campo);
		$('#numero_itens_incluidos').val(numero_campo+1);
		
		valor_total = moeda2numero($('#valor_total').html());
		valor_total = parseFloat(valor_total);
		valor_total += quantidade * (moeda2numero(valor));
		valor_total = arredonda_float(valor_total);
		$('#valor_total').html(numero2moeda(valor_total));
		
		limpar_pesquisa();
		$('#preco_custo').val('0');
		$('#ProdutoId').focus();
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
		$('#produtos_pesquisar input').each(function() {
			$(this).val('');
		});
	});
}

//#TODO exibir valor total, considerando todos os custos e desconto
function calculaValortotal () {
	$(function(){
		
	});
}
