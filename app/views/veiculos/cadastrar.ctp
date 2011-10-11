<h2 class="descricao_cabecalho">Cadastrar veículo</h2>

<?php print $form->create('Veiculo',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;')); ?>
<div class="divs_grupo_2">
	<div class="div1_2">
		<?php
		print $form->input('modelo',array('label'=>'Modelo'));
		print $form->input('placa',array('label'=>'Placa'));
		print $form->input('fabricante',array('label'=>'Fabricante'));
		?>
	</div>
	<div class="div2_2">
		<?php
		print $form->input('ano',array('label'=>'Ano'));
		print $form->input('tipo',array('label'=>'Tipo','options'=>$tipos_veiculo));
		?>
	</div>
</div>
<?php print $form->end('Gravar'); ?>
