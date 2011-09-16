<script type="text/javascript">
	$(document).ready(function() {
		
		//Para situações onde o formulario será carregado já populado
		if ($('[name="data[Cliente][tipo_pessoa]"]').val() == 'F' ) {
			$('#ClienteCpf').removeAttr('disabled');
			$('#ClienteRg').removeAttr('disabled');
		}
		else if ($('[name="data[Cliente][tipo_pessoa]"]').val() == 'J' ) {
			$('#ClienteCnpj').removeAttr('disabled');
			$('#ClienteInscricaoEstadual').removeAttr('disabled');
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
			else if ($(this).val() == 'J' ) {
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
</script>

<h2 class="descricao_cabecalho">
	Editar cliente
</h2>

<?php print $form->create('Cliente',array('autocomplete'=>'off')); ?>

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
	<div style="position: absolute; float: left; margin-left: 150px;">
	<?php
		print $form->label('situacao','Situação',array('class'=>'required'));
		print $form->input('situacao',array(
			'div'=>false,
			'label'=>false,
			'options'=>array(''=>'','A'=>'Ativo','I'=>'Inativo','B'=>'Bloqueado')
			));
		?>
	</div>

<div style="position: absolute; float: left; margin-left: 300px;">
<?php
	print $form->label('cliente_categoria_id','Categoria do cliente',array('class'=>'required'));
	print $form->input('cliente_categoria_id',array(
		'div'=>false,
		'label'=>false,
		'options'=>$opcoes_categoria_cliente
		));
	?>
</div>
<div style="position: absolute; float: left; margin-left: 500px;">
<?php
	print $form->label('empresa_id','Empresa',array('class'=>'required'));
	print $form->input('empresa_id',array(
		'div'=>false,
		'label'=>false,
		'options'=>$opcoes_empresa
		));
	?>
</div>

<div class="limpar">&nbsp;</div>
<div class="divs_grupo_3">
	<div class="div1_3">
		<?php
		print $form->input('nome', array('label'=>'Nome'));
		print $form->input('nome_fantasia', array('label'=>'Nome fantasia'));
		print $form->input('logradouro_nome', array('label'=>'Logradouro'));
		print $form->input('logradouro_numero', array('label'=>'Número'));
		print $form->input('logradouro_complemento', array('label'=>'Complemento'));
		?>
	</div>
	
	<div class="div2_3">
		<?php
		print $form->input('bairro');
		print $form->input('cidade');
		print $estados->input('uf',array('label'=>'UF'));
		print $form->input('cep', array('label'=>'CEP'));
		print $form->input('numero_telefone', array('label'=>'Número de telefone'));
		?>
	</div>
	
	<div class="div3_3">
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
<div class="limpar"></div>
<?php
print $form->input('observacao', array('label'=>'Observação') );
print $form->end('Gravar');
?>
