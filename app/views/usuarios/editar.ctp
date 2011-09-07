<h2 class="descricao_cabecalho">
	Alterar usuário
</h2>

<?php
print $form->create('Usuario', array('autocomplete'=>'off'));
?>
<div id="divs_grupo_2">
	
	<div id="div1_2">
		<?php
		print $form->input('nome', array('label'=>'Nome'));
		print $form->input('login',array('label'=>'Login'));
		print $form->input('senha', array('label'=>'Senha','type'=>'password'));
		print $form->input('senha_confirma', array('label'=>'Redigite a senha','type'=>'password'));
		?>
	</div>
	
	<div id="div2_2">
		<?php
		print $form->input('permissao', array('label'=>'Permissão','options'=>array('0'=>'Administrador','1'=>'Usuário comum')));
		print $form->input('email', array('label'=>'Endereço de e-mail'));
		print $form->input('ativo', array('label'=>'Ativo?','checked'=>'checked'));
		?>
	</div>
	<div class="limpar">&nbsp;</div>
</div>
<div class="limpar">&nbsp;</div>
<?php print $form->end('Gravar'); ?>
