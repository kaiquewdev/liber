<script type="text/javascript">
	// variaveis a serem utilizadas no arquivo conta_receber.js
	var raiz_site = "<?php print $this->Html->url('/',true); ?>/";
	var ajaxPesqCliente = "<?php print $this->Html->url(array('controller'=>'Clientes','action'=>'pesquisaAjaxCliente')); ?>/";
	var ajaxPesqFornecedor = "<?php print $this->Html->url(array('controller'=>'Fornecedores','action'=>'pesquisaAjaxFornecedor')); ?>/";
</script>

<?php
//#FIXME Ao recuperar a data ela nao volta para o padrao brasileiro
//# exibir alerta se a data de vencimento for menor que a data atual?
$javascript->link('conta_receber.js',false);
$javascript->link('formatar_moeda.js',false);
?>

<h2 class="descricao_cabecalho">Editar conta a receber</h2>

<?php print $form->create('ReceberConta',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;')); ?>
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
		<div>
			<?php
			print $form->label('cliente_fornecedor_id','Cliente/fornecedor',array('class'=>'required'));
			print $form->input('cliente_fornecedor_id', array(
				'div'=>false,
				'label'=>false,
				'type'=>'text',
				'style' => 'float:left; width: 10%;'
				));
			?>
			<input style="margin-left: 1%; width: 80%" type="text" name="pesquisar_cliente_fornecedor" id="pesquisar_cliente_fornecedor" />
		</div>
		<?php
		print $form->input('tipo_documento_id',array('label'=>'Tipo documento','options'=>$opcoes_tipo_documento));
		print $form->input('numero_documento',array('label'=>'Número documento'));
		print $form->input('valor',array('label'=>'Valor'));
		?>
	</div>
	<div class="div2_2">
		<?php
		print $form->input('conta_origem',array('label'=>'Conta de origem','options'=>$opcoes_conta_origem));
		print $form->input('plano_conta_id',array('label'=>'Plano de contas','options'=>$opcoes_plano_contas));
		print $form->input('data_vencimento',array('label'=>'Data do vencimento','type'=>'text','class'=>'datepicker mascara_data'));
		?>
	</div>
</div>
<div class="limpar">&nbsp;</div>

<?php
print $form->input('observacao',array('label'=>'Observação'));
print $form->end('Gravar');
?>
