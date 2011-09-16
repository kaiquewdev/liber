<h2 class="descricao_cabecalho">Editar categoria de produto</h2>

<?php print $form->create('CategoriaProduto',array('autocomplete'=>'off'));
print $form->input('nome',array('label'=>'Nome'));
print $form->end('Gravar');
?>
