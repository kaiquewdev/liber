<h2 class="descricao_cabecalho">Enviar carregamento</h2>

<?php
print $form->create(null,
	array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;','action'=>'enviar', 'method'=>'post'));
print $form->input('id',array('label'=>'Número','type'=>'text'));
print $form->end('Enviar');
?>

