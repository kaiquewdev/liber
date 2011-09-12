<h2 class="descricao_cabecalho">Cadastrar empresa</h2>

<?php print $form->create('Empresa',array('autocomplete'=>'off')); ?>
<div id="divs_grupo_3">
	<div id="div1_3">
		<?php
		print $form->input('nome',array('label'=>'Nome'));
		print $form->input('cnpj',array('label'=>'CNPJ'));
		print $form->input('inscricao_estadual',array('label'=>'Inscrição estadual'));
		print $form->input('telefone',array('label'=>'Número de telefone'));
		print $form->input('fax',array('label'=>'Número de fax'));
		?>
	</div>
	<div id="div2_3">
		<?php
		print $form->input('site',array('label'=>'Site da empresa'));
		print $form->input('endereco_email_principal',array('label'=>'Endereço de e-mail principal'));
		print $form->input('endereco_email_secundario',array('label'=>'Endereço de e-mail secundário'));
		print $form->input('logradouro',array('label'=>'Logradouro'));
		?>
	</div>
	<div id="div3_3">
		<?php
		print $form->input('numero',array('label'=>'Número'));
		print $form->input('bairro',array('label'=>'Bairro'));
		print $form->input('complemento',array('label'=>'Complemento'));
		print $form->input('cidade',array('label'=>'Cidade'));
		print $estados->input('estado',array('label'=>'Estado'));
		?>
	</div>
</div>
<?php print $form->end('Gravar'); ?>
