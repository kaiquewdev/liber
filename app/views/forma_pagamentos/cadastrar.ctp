<script type="text/javascript">
$(function(){
	if ( $('#FormaPagamentoValorMinimoParcela').val() == '' ) {
		$('#FormaPagamentoValorMinimoParcela').val('0');
	}
	if ( $('#FormaPagamentoPorcentagemJuros').val() == '' ) {
		$('#FormaPagamentoPorcentagemJuros').val('0');
	}
});
</script>

<h2 class="descricao_cabecalho">Cadastrar forma de pagamento</h2>

<?php

print $form->create('FormaPagamento',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;'));
?>
<div class="divs_grupo_2">
	<div class="div1_2">
		<?php
		print $form->input('nome',array('label'=>'Nome'));
		print $form->input('numero_maximo_parcelas',array('label'=>'Número máximo de parcelas','options'=>$numero_maximo_parcelas));
		print $form->input('numero_parcelas_sem_juros',array('label'=>'Número de parcelas sem juros','options'=>$numero_parcelas_sem_juros));
		print $form->input('dias_intervalo_parcelamento',array('label'=>'Período de intervalo das parcelas', 'options'=>$dias_intervalo_parcelas));
		?>
	</div>
	<div class="div2_2">
		<?php
		print $form->input('valor_minimo_parcela',array('label'=>'Valor mínimo por parcela'));
		print $form->input('porcentagem_juros',array('label'=>'Porcentagem de juros'));
		print $form->input('tipo_documento_id',array('label'=>'Documento','options'=>$opcoes_documentos));
		print $form->input('conta_principal',array('label'=>'Conta principal','options'=>$opcoes_contas));
		?>
		<br/><br/><br/>
	</div>
</div>
<?php print $form->end('Gravar'); ?>
