<h2 class="descricao_cabecalho">Cadastrar serviço</h2>

<?php print $form->create('Servico',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;')); ?>
<div class="divs_grupo_2">
	<div class="div1_2">
		<?php
		print $form->input('nome',array('label'=>'Nome'));
		print $form->input('valor',array('label'=>'Valor'));
		?>
	</div>
	<div class="div2_2">
		<?php
		print $form->input('servico_categoria_id',array('label'=>'Categoria','options'=>$opcoes_servico_categoria));
		?>
	</div>
</div>
<?php print $form->end('Gravar'); ?>
