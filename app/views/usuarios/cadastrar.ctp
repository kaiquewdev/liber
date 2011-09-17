<h2 class="descricao_cabecalho">
	Cadastrar usuário
</h2>

<?php
print $form->create('Usuario', array('autocomplete'=>'off'));
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
		print $form->input('permissao', array('label'=>'Permissão','options'=>
		array(
		'0'=>'Administrador',
		'1'=>'Usuário comum',
		'2' => 'Vendedor',
		'3' => 'Técnico'
		)));
		print $form->input('email', array('label'=>'Endereço de e-mail'));
		print $form->input('ativo', array('label'=>'Ativo?','checked'=>'checked'));
		?>
	</div>
	<div class="limpar">&nbsp;</div>
</div>
<div class="limpar">&nbsp;</div>
<?php print $form->end('Gravar'); ?>
