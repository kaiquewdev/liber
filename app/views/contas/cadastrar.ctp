<h2 class="descricao_cabecalho">Cadastrar conta</h2>

<?php print $form->create('Conta',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;')); ?>
<div class="divs_grupo_2">
	<div class="div1_2">
		<?php
		print $form->input('nome',array('label'=>'Nome'));
		print $form->input('apelido',array('label'=>'Apelido'));
		print $form->input('banco',array('label'=>'Banco'));
		?>
	</div>
	<div class="div2_2">
		<?php
		print $form->input('agencia',array('label'=>'Agência'));
		print $form->input('conta',array('label'=>'Conta'));
		print $form->input('titular',array('label'=>'Titular'));
		?>
	</div>
</div>
<?php print $form->end('Gravar'); ?>
