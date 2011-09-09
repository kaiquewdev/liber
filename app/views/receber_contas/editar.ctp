<h2 class="descricao_cabecalho">Editar conta a receber</h2>

<?php print $form->create('ReceberConta',array('autocomplete'=>'off')); ?>
<div id="divs_grupo_2">
	<div id="div1_2">
		<?php
		print $form->input('eh_cliente_ou_fornecedor',array('label'=>'Tipo','options'=>array(''=>'','C'=>'Cliente','F'=>'Fornecedor')));
		print $form->input('cliente_fornecedor_id',array('label'=>'Código cliente/fornecedor','type'=>'text'));
		print $form->input('tipo_documento_id',array('label'=>'Tipo documento','options'=>$opcoes_tipo_documento));
		print $form->input('numero_documento',array('label'=>'Número documento'));
		?>
	</div>
	<div id="div2_2">
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
