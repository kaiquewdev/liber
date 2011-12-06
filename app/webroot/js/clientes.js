$( function() {
		
		//Para situações onde o formulario será carregado já populado
		if ($('[name="data[Cliente][tipo_pessoa]"]').val() == 'F' ) {
			$('#ClienteCpf')
				.removeAttr('disabled')
				.parent('div').addClass('required');
			$('#ClienteRg')
				.removeAttr('disabled')
				.parent('div').addClass('required');
			
		}
		else if ($('[name="data[Cliente][tipo_pessoa]"]').val() == 'J' ) {
			$('#ClienteCnpj')
				.removeAttr('disabled')
				.parent('div').addClass('required');
			$('#ClienteInscricaoEstadual')
				.removeAttr('disabled')
				.parent('div').addClass('required');
		}
		
		$('#ClienteNome').focusout(function() {
			if ($('#ClienteNomeFantasia').val() == '') {
				$('#ClienteNomeFantasia').val($('#ClienteNome').val());
			}
		});
		
		//Ao ser setado, manualmente, o tipo do cliente
		$('[name="data[Cliente][tipo_pessoa]"]').change(function(){
			if ($(this).val() == 'F' ) {
				$('#ClienteCnpj')
					.val("")
					.attr("disabled", "disabled")
					.parent('div').removeClass('required');
				$('#ClienteInscricaoEstadual')
					.val("")
					.attr("disabled", "disabled")
					.parent('div').removeClass('required');
				
				$('#ClienteCpf')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000)
					.parent('div').addClass('required');
				$('#ClienteRg')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000)
					.parent('div').addClass('required');
			}
			else if ($(this).val() == 'J' ) {
				$('#ClienteCpf')
					.val("")
					.attr("disabled", "disabled")
					.parent('div').removeClass('required');
				$('#ClienteRg')
					.val("")
					.attr("disabled", "disabled")
					.parent('div').removeClass('required');
					
				$('#ClienteCnpj')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000)
					.parent('div').addClass('required');
				$('#ClienteInscricaoEstadual')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000)
					.parent('div').addClass('required');
			}
		});
		
		$('input[value="Gravar"]').click(function () {
			if ($('[name="data[Cliente][tipo_pessoa]"]').val() == 'J' ){
				if ( ($('#ClienteCnpj').val() == "") || ($('#ClienteInscricaoEstadual').val() == "") ) {
					alert ("Para pessoa jurídica os campos CNPJ e I.E. são obrigatórios.");
					return false;
				}
			}
			else if ($('[name="data[Cliente][tipo_pessoa]"]').val() == 'F' ) {
				if ( ($('#ClienteCpf').val() == "") || ( $('#ClienteRg').val() == "") ) {
					alert ("Para pessoa física os campos CPF e RG são obrigatórios.");
					return false;
				} 
			}
			
		});
		
		
	});