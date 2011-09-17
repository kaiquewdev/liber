$( function() {
		
		//Para situações onde o formulario será carregado já populado
		if ($('[name="data[Fornecedor][tipo_pessoa]"]').val() == 'F' ) {
			$('#FornecedorCpf')
				.removeAttr('disabled')
				.parent('div').addClass('required');
			$('#FornecedorRg')
				.removeAttr('disabled')
				.parent('div').addClass('required');
			
		}
		else if ($('[name="data[Fornecedor][tipo_pessoa]"]').val() == 'J' ) {
			$('#FornecedorCnpj')
				.removeAttr('disabled')
				.parent('div').addClass('required');
			$('#FornecedorInscricaoEstadual')
				.removeAttr('disabled')
				.parent('div').addClass('required');
		}
		
		$('#FornecedorNome').focusout(function() {
			if ($('#FornecedorNomeFantasia').val() == '') {
				$('#FornecedorNomeFantasia').val($('#FornecedorNome').val());
			}
		});
		
		//Ao ser setado, manualmente, o tipo do cliente
		$('[name="data[Fornecedor][tipo_pessoa]"]').change(function(){
			if ($(this).val() == 'F' ) {
				$('#FornecedorCnpj')
					.val("")
					.attr("disabled", "disabled")
					.parent('div').removeClass('required');
				$('#FornecedorInscricaoEstadual')
					.val("")
					.attr("disabled", "disabled")
					.parent('div').removeClass('required');
				
				$('#FornecedorCpf')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000)
					.parent('div').addClass('required');
				$('#FornecedorRg')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000)
					.parent('div').addClass('required');
			}
			else if ($(this).val() == 'J' ) {
				$('#FornecedorCpf')
					.val("")
					.attr("disabled", "disabled")
					.parent('div').removeClass('required');
				$('#FornecedorRg')
					.val("")
					.attr("disabled", "disabled")
					.parent('div').removeClass('required');
					
				$('#FornecedorCnpj')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000)
					.parent('div').addClass('required');
				$('#FornecedorInscricaoEstadual')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000)
					.parent('div').addClass('required');
			}
		});
		
		$('input[value="Gravar"]').click(function () {
			if ($('[name="data[Fornecedor][tipo_pessoa]"]').val() == 'J' ){
				if ( ($('#FornecedorCnpj').val() == "") || ($('#FornecedorInscricaoEstadual').val() == "") ) {
					alert ("Para pessoa jurídica os campos CNPJ e I.E. são obrigatórios.");
					return false;
				}
			}
			else if ($('[name="data[Fornecedor][tipo_pessoa]"]').val() == 'F' ) {
				if ( ($('#FornecedorCpf').val() == "") || ( $('#FornecedorRg').val() == "") ) {
					alert ("Para pessoa física os campos CPF e RG são obrigatórios.");
					return false;
				} 
			}
			
		});
		
		
	});