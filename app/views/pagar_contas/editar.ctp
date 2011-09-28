<h2 class="descricao_cabecalho">Editar conta a pagar</h2>

<?php print $form->create('PagarConta',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;')); ?>
<div class="grupo_horizontal">
	<?php
	print $form->label('eh_cliente_ou_fornecedor','É cliente ou fornecedor?',array('class'=>'required'));
	print $form->input('eh_cliente_ou_fornecedor', array(
		'div'=>false,
		'label'=>false,
		'options'=>array(''=>'','C'=>'Cliente','F'=>'Fornecedor')
		));
	?>
</div>
		
<div class="grupo_horizontal">
	<?php
	print $form->label('eh_fical','É fiscal?',array('class'=>'required'));
	print $form->input('eh_fiscal', array(
		'div'=>false,
		'label'=>false,
		'options'=>array('0'=>'Não','1'=>'Sim')
		));
	?>
</div>
<div class="limpar"></div>

<div class="divs_grupo_2">
	<div class="div1_2">
		
		<?php
		print $form->input('cliente_fornecedor_id',array('label'=>'Código cliente/fornecedor','type'=>'text'));
		print $form->input('tipo_documento_id',array('label'=>'Tipo documento','options'=>$opcoes_tipo_documento));
		print $form->input('numero_documento',array('label'=>'Número documento'));
		?>
	</div>
	<div class="div2_2">
		<?php
		print $form->input('valor',array('label'=>'Valor'));
		print $form->input('conta_origem',array('label'=>'Conta de origem','options'=>$opcoes_conta_origem));
		print $form->input('plano_conta_id',array('label'=>'Plano de contas','options'=>$opcoes_plano_contas));
		print $form->input('data_vencimento',array('label'=>'Data do vencimento'));
		?>
	</div>
</div>

<?php
print $form->input('observacao',array('label'=>'Observação'));
print $form->end('Gravar');
?>
