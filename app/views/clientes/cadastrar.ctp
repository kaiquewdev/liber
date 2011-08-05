<?php
print $html->script('jquery-ui');
$html->css("jquery-ui/jquery-ui.css", null, array("inline"=>false));
?>

<script type="text/javascript">
	$(document).ready(function() {
		
		$('#ClienteNome').focusout(function() {
			if ($('#ClienteNomeFantasia').val() == '') {
				$('#ClienteNomeFantasia').val($('#ClienteNome').val());
			}
		});
		
		$('[name="data[Cliente][tipo_pessoa]"]').change(function(){
			if ($("#ClienteTipoPessoaF").is(':checked') ) {
				$('#ClienteCnpj')
					.val("")
					.attr("disabled", "disabled");
				$('#ClienteInscricaoEstadual')
					.val("")
					.attr("disabled", "disabled");
				
				$('#ClienteCpf')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000);
				$('#ClienteRg')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000);
					
			}
			else if ($("#ClienteTipoPessoaJ").is(':checked') ) {
				$('#ClienteCpf')
					.val("")
					.attr("disabled", "disabled");
				$('#ClienteRg')
					.val("")
					.attr("disabled", "disabled");
					
				$('#ClienteCnpj')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000);
				$('#ClienteInscricaoEstadual')
					.removeAttr('disabled')
					.effect("highlight", {}, 3000);
			}
			
		});
		
	});
</script>

<h2>Adicionar cliente</h2>

<?php

print $form->create('Cliente');

print $form->radio('tipo_pessoa',
array('F'=>'Física','J'=>'Jurídica'),
array('legend'=>'Tipo de pessoa:') );
?>
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
		?>
	</div>
	
</div>

<?php
print $form->input('observacao', array('label'=>'Observação') );
print $form->end('Gravar');	
?>
