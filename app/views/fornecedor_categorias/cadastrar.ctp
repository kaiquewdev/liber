<h2 class="descricao_cabecalho">Cadastrar categoria de fornecedor</h2>

<?php print $form->create('FornecedorCategoria',array('autocomplete'=>'off'));
print $form->input('descricao',array('label'=>'Descrição'));
print $form->end('Gravar');
?>
