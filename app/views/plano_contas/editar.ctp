<h2 class="descricao_cabecalho">Editar item do plano de contas</h2>

<?php
$opcoes = array(
	'D'=>'Despesas',
	'R'=>'Receitas',
	'E'=>'Especiais'
);
print $form->create('PlanoConta',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;'));
print $form->input('nome',array('label'=>'Nome'));
print $form->input('tipo',array('label'=>'Tipo','options'=>$opcoes));
print $form->end('Gravar');
?>
