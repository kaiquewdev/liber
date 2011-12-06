$(function(){
	
	$(".datepicker").datepicker({
		showOn: "button",
		buttonImage: raiz_site+"/img/calendario_icone.gif",
		buttonImageOnly: true
	});
	
	$('#ReceberContaValor').priceFormat();
	
	function valor_padrao() {
		$('label[for=ReceberContaClienteFornecedorId]').html('Cliente/Fornecedor');
		$('#pesquisar_cliente_fornecedor')
			.attr('disabled','disabled')
			.val('Selecione uma opção no menu acima.');
		$("#ReceberContaClienteFornecedorId")
			.attr('disabled','disabled')
			.val('');
	}
	
	// Definido assim que a pagina é carregada
	if ($("#ReceberContaClienteFornecedorId").val() == '') valor_padrao();
	
	// Aplica, as opcoes de pesquisa pelo codigo ou pelo nome
	// do cliente ou fornecedor
	function definir_pesquisa (cliente_ou_fornecedor) {
		
		if (cliente_ou_fornecedor == 'cliente') ajaxPesquisa = ajaxPesqCliente;
		else if (cliente_ou_fornecedor == 'fornecedor') ajaxPesquisa = ajaxPesqFornecedor;
		else return 0;
		
		//autocomplete
		$("#pesquisar_cliente_fornecedor").autocomplete({
			source: ajaxPesquisa + "nome",
			minLength: 3,
			select: function(event, ui) {
				if (ui.item.bloqueado) {
					alert (cliente_ou_fornecedor+' está bloqueado!');
					$('#pesquisar_cliente_fornecedor').val('');
					$("#ReceberContaClienteFornecedorId").val('');
					event.preventDefault();
					return null;
				}
				if (ui.item.inativo) {
					alert (cliente_ou_fornecedor+' está inativo!');
					$('#pesquisar_cliente_fornecedor').val('');
					$("#ReceberContaClienteFornecedorId").val('');
					event.preventDefault();
					return null;
				}
				$("#ReceberContaClienteFornecedorId").val(ui.item.id);
				$('#pesquisar_cliente_fornecedor').val(ui.item.nome);
			}
		});
		// ao digitar o codigo
		$('#ReceberContaClienteFornecedorId').blur(function(){
			codigo = $(this).val();
			if (codigo == null || codigo == '') return null;
			$.getJSON(ajaxPesquisa + 'codigo', {'term': codigo}, function(data) {
				if (data == null) {
					alert (cliente_ou_fornecedor+' com o código '+codigo+' não foi encontrado!');
					$('#pesquisar_cliente_fornecedor').val('');
					$("#ReceberContaClienteFornecedorId")
						.val('')
						.focus();
				}
				else { //encontrou resultados
					data = data[0];
					if (data.bloqueado) {
						alert (cliente_ou_fornecedor+' está bloqueado!');
						$('#pesquisar_cliente_fornecedor').val('');
						$("#ReceberContaClienteFornecedorId").val('');
						return null;
					}
					if (data.inativo) {
						alert (cliente_ou_fornecedor+' está inativo!');
						$('#pesquisar_cliente_fornecedor').val('');
						$("#ReceberContaClienteFornecedorId").val('');
						return null;
					}
					$("#ReceberContaClienteFornecedorId").val(data.id);
					$('#pesquisar_cliente_fornecedor').val(data.nome);
				}
			});
		});
	}
	
	// de acordo com o selecionado, defino o que será pesquisado
	$('#ReceberContaEhClienteOuFornecedor').change(function(){
		
		$('#pesquisar_cliente_fornecedor')
			.removeAttr('disabled')
			.val('');
		$("#ReceberContaClienteFornecedorId")
			.removeAttr('disabled')
			.val('');
		
		if ($(this).val() == 'C') {
			$('label[for=ReceberContaClienteFornecedorId]').html('Cliente');
			definir_pesquisa('cliente');
		}
		else if ($(this).val() == 'F') {
			$('label[for=ReceberContaClienteFornecedorId]').html('Fornecedor');
			definir_pesquisa('fornecedor');
		}
		else {
			valor_padrao();
		}
		
	});
	
});
