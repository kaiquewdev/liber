<script type="text/javascript">
	$(document).ready(function() {
		
		//Para situações onde o formulario será carregado já populado
		if ($('[name="data[Fornecedor][tipo_pessoa]"]').val() == 'F' ) {
			$('#FornecedorCpf').removeAttr('disabled');
			$('#FornecedorRg').removeAttr('disabled');
		}
		else if ($('[name="data[Fornecedor][tipo_pessoa]"]').val() == 'J' ) {
			$('#FornecedorCnpj').removeAttr('disabled');
			$('#FornecedorInscricaoEstadual').removeAttr('disabled');
		}
		
		$('#FornecedorNome').focusout(function() {
			if ($('#FornecedorNomeFantasia').val() == '') {
				$('#FornecedorNomeFantasia').val($('#FornecedorNome').val());
			}
		});
		
		//Ao ser setado, manualmente, o tipo do fornecedor
		$('[name="data[Fornecedor][tipo_pessoa]"]').change(function(){
			if ($(this).val() == 'F' ) {
				$('#FornecedorCnpj')
					.val("")
					.attr("disabled", "disabled");
				$('#FornecedorInscricaoEstadual')
					.val("")
					.attr("disabled", "disabled");
				
				$('#FornecedorCpf')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000);
				$('#FornecedorRg')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000);
			}
			else if ($(this).val() == 'J' ) {
				$('#FornecedorCpf')
					.val("")
					.attr("disabled", "disabled");
				$('#FornecedorRg')
					.val("")
					.attr("disabled", "disabled");
					
				$('#FornecedorCnpj')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000);
				$('#FornecedorInscricaoEstadual')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000);
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
			
			r = confirm("Confirma o envio dos dados?");
			if (! r) return false;
		});
		
		
	});
</script>

<h2 class="descricao_cabecalho">
	<?php
	if ($acao == "adicionar") print "Adicionar fornecedor";
	else if ($acao == "editar") print "Editar fornecedor";
	?>
</h2>

<?php print $form->create('Fornecedor',array('autocomplete'=>'off')); ?>

<div>
	<div style="float: left; position: absolute;">
		<?php
		print $form->label('tipo_pessoa','Tipo pessoa',array('class'=>'required'));
		print $form->input('tipo_pessoa', array(
			'div'=>false,
			'label'=>false,
			'options'=>array(''=>'','F'=>'Física','J'=>'Jurídica')
			));
		?>
	</div>
	<div style="margin-left: 150px;">
	<?php
		print $form->label('situacao','Situação',array('class'=>'required'));
		print $form->input('situacao',array(
			'div'=>false,
			'label'=>false,
			'options'=>array(''=>'','A'=>'Ativo','I'=>'Inativo','B'=>'Bloqueado')
			));
		?>
	</div>
</div>

<div id="divs_grupo_3">
	<div id="div1_3">
		<?php
		print $form->input('nome', array('label'=>'Nome'));
		print $form->input('nome_fantasia', array('label'=>'Nome fantasia'));
		print $form->input('logradouro_nome', array('label'=>'Logradouro'));
		print $form->input('logradouro_numero', array('label'=>'Número'));
		print $form->input('logradouro_complemento', array('label'=>'Complemento'));
		?>
	</div>
	
	<div id="div2_3">
		<?php
		print $form->input('bairro');
		print $form->input('cidade');
		print $estados->input('uf',array('label'=>'UF'));
		print $form->input('cep', array('label'=>'CEP'));
		print $form->input('numero_telefone', array('label'=>'Número de telefone'));
		?>
	</div>
	
	<div id="div3_3">
		<?php
		print $form->input('endereco_email', array('label'=>'Endereço de e-mail'));
		print $form->input('cnpj',array('label'=>'CNPJ', 'disabled'=>'disabled'));
		print $form->input('inscricao_estadual',array('label'=>'Inscrição estadual', 'disabled'=>'disabled'));
		print $form->input('cpf',array('label'=>'CPF', 'disabled'=>'disabled'));
		print $form->input('rg',array('label'=>'RG', 'disabled'=>'disabled'));
		print $form->input('inscricao_municipal',array('label'=>'Registro municipal'));
		?>
	</div>
	
</div>

<?php
print $form->input('observacao', array('label'=>'Observação') );
print $form->end('Gravar');
?>
