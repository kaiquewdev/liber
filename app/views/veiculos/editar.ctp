<h2 class="descricao_cabecalho">Editar veículo</h2>

<?php print $form->create('Veiculo',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;')); ?>
<div class="divs_grupo_2">
	<div class="div1_2">
		<?php
		print $form->input('modelo',array('label'=>'Modelo'));
		print $form->input('placa',array('label'=>'Placa'));
		print $form->input('fabricante',array('label'=>'Fabricante'));
		print $form->input('ano',array('label'=>'Ano','type'=>'text'));
		?>
	</div>
</div>
<?php print $form->end('Gravar'); ?>
