<h2 class="descricao_cabecalho">Alterar tipo de documento</h2>

<?php
print $form->create('TipoDocumento',array('autocomplete'=>'off'));
print $form->input('nome',array('label'=>'Nome'));
print $form->end('Gravar');
?>
