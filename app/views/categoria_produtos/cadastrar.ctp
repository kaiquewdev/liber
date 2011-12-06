<h2 class="descricao_cabecalho">Cadastrar categoria de produto</h2>

<?php print $form->create('CategoriaProduto',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;'));
print $form->input('nome',array('label'=>'Nome'));
print $form->end('Gravar');
?>
