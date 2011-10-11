<h2 class="descricao_cabecalho">Editar motorista</h2>

<?php print $form->create('Motorista',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;')); ?>
<div class="divs_grupo_2">
	<div class="div1_2">
		<?php
		print $form->input('nome',array('label'=>'Nome'));
		print $form->input('sexo',array('label'=>'Sexo','options'=>array('M'=>'Masculino','F'=>'Feminino')));
		print $form->input('logradouro_nome',array('label'=>'Logradouro'));
		print $form->input('logradouro_numero',array('label'=>'Número'));
		print $form->input('logradouro_complemento',array('label'=>'Complemento'));
		?>
	</div>
	<div class="div2_2">
		<?php
		print $form->input('cnh_numero_registro',array('label'=>'Número de registro da C.N.H.'));
		print $form->input('cnh_data_validade',array('label'=>'Data de validade da C.N.H.','type'=>'text','class'=>'datepicker mascara_data'));
		print $form->input('cnh_categoria',array('label'=>'Categoria da C.N.H.'));
		print $form->input('veiculo_id',array('label'=>'Principal veículo','options'=>$opcoes_veiculo));
		?>
	</div>
</div>
<?php print $form->end('Gravar'); ?>
