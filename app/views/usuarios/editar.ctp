<h2 class="descricao_cabecalho">
	Editar usuário
</h2>

<?php
print $form->create('Usuario', array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;'));
?>
<div class="divs_grupo_2">
	
	<div class="div1_2">
		<?php
		print $form->input('nome', array('label'=>'Nome'));
		print $form->input('login',array('label'=>'Login'));
		print $form->input('senha', array('label'=>'Senha','type'=>'password'));
		print $form->input('senha_confirma', array('label'=>'Redigite a senha','type'=>'password'));
		?>
	</div>
	
	<div class="div2_2">
		<?php
		print $form->input('tipo', array('label'=>'Tipo de usuário','options'=>
		array(
		'0'=>'Administrador',
		'1'=>'Usuário comum',
		'2' => 'Vendedor',
		'3' => 'Técnico'
		)));
		print $form->input('email', array('label'=>'Endereço de e-mail'));
		print $form->input('ativo', array('label'=>'Ativo?','checked'=>'checked'));
		print $form->input('eh_tecnico',array('label'=>'É técnico?'));
		print $form->input('eh_vendedor',array('label'=>'É vendedor?'));
		?>
	</div>
	<div class="limpar">&nbsp;</div>
</div>
<div class="limpar">&nbsp;</div>
<?php print $form->end('Gravar'); ?>
