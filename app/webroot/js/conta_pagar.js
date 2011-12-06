$(function(){
	
	$(".datepicker").datepicker({
		showOn: "button",
		buttonImage: raiz_site+"/img/calendario_icone.gif",
		buttonImageOnly: true
	});
	
	$('#PagarContaValor').priceFormat();
	
	function valor_padrao() {
		$('label[for=PagarContaClienteFornecedorId]').html('Cliente/Fornecedor');
		$('#pesquisar_cliente_fornecedor')
			.attr('disabled','disabled')
			.val('Selecione uma opção no menu acima.');
		$("#PagarContaClienteFornecedorId")
			.attr('disabled','disabled')
			.val('');
	}
	
	// Definido assim que a pagina é carregada
	if ($("#PagarContaClienteFornecedorId").val() == '') valor_padrao();
	
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
					$("#PagarContaClienteFornecedorId").val('');
					event.preventDefault();
					return null;
				}
				if (ui.item.inativo) {
					alert (cliente_ou_fornecedor+' está inativo!');
					$('#pesquisar_cliente_fornecedor').val('');
					$("#PagarContaClienteFornecedorId").val('');
					event.preventDefault();
					return null;
				}
				$("#PagarContaClienteFornecedorId").val(ui.item.id);
				$('#pesquisar_cliente_fornecedor').val(ui.item.nome);
			}
		});
		// ao digitar o codigo
		$('#PagarContaClienteFornecedorId').blur(function(){
			codigo = $(this).val();
			if (codigo == null || codigo == '') return null;
			$.getJSON(ajaxPesquisa + 'codigo', {'term': codigo}, function(data) {
				if (data == null) {
					alert (cliente_ou_fornecedor+' com o código '+codigo+' não foi encontrado!');
					$('#pesquisar_cliente_fornecedor').val('');
					$("#PagarContaClienteFornecedorId")
						.val('')
						.focus();
				}
				else { //encontrou resultados
					data = data[0];
					if (data.bloqueado) {
						alert (cliente_ou_fornecedor+' está bloqueado!');
						$('#pesquisar_cliente_fornecedor').val('');
						$("#PagarContaClienteFornecedorId").val('');
						return null;
					}
					if (data.inativo) {
						alert (cliente_ou_fornecedor+' está inativo!');
						$('#pesquisar_cliente_fornecedor').val('');
						$("#PagarContaClienteFornecedorId").val('');
						return null;
					}
					$("#PagarContaClienteFornecedorId").val(data.id);
					$('#pesquisar_cliente_fornecedor').val(data.nome);
				}
			});
		});
	}
	
	// de acordo com o selecionado, defino o que será pesquisado
	$('#PagarContaEhClienteOuFornecedor').change(function(){
		
		$('#pesquisar_cliente_fornecedor')
			.removeAttr('disabled')
			.val('');
		$("#PagarContaClienteFornecedorId")
			.removeAttr('disabled')
			.val('');
		
		if ($(this).val() == 'C') {
			$('label[for=PagarContaClienteFornecedorId]').html('Cliente');
			definir_pesquisa('cliente');
		}
		else if ($(this).val() == 'F') {
			$('label[for=PagarContaClienteFornecedorId]').html('Fornecedor');
			definir_pesquisa('fornecedor');
		}
		else {
			valor_padrao();
		}
		
	});
	
});
