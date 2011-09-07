<h2 class="descricao_cabecalho">Cadastrar forma de pagamento</h2>

<?php

print $form->create('FormaPagamento',array('autocomplete'=>'off'));
?>
<div id="divs_grupo_2">
	<div id="div1_2">
		<?php
		print $form->input('nome',array('label'=>'Nome'));
		print $form->input('numero_maximo_parcelas',array('label'=>'Número máximo de parcelas','options'=>$numero_maximo_parcelas));
		print $form->input('dias_intervalo_parcelamento',array('label'=>'Período de intervalo das parcelas', 'options'=>$dias_intervalo_parcelas));
		print $form->input('conta_principal',array('label'=>'Conta principal','options'=>$opcoes_contas));
		?>
	</div>
	<div id="div2_2">
		<?php
		print $form->input('valor_taxa_fixa',array('label'=>'Valor para taxa fixa','value'=>0));
		print $form->input('porcentagem_juros',array('label'=>'Porcentagem de juros','value'=>0));
		print $form->input('numero_parcelas_sem_juros',array('label'=>'Número de parcelas sem juros','options'=>$numero_parcelas_sem_juros));
		?>
		<br/><br/><br/>
	</div>
</div>
<?php print $form->end('Gravar'); ?>
