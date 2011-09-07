<div id="login">

	<?php
	print $this->Session->flash('auth');
	print $form->create('Usuario', array('action'=>'login','autocomplete'=>'off'));
	print $form->input('login',array('label'=>'Login'));
	print $form->input('senha', array('type'=>'password'));
	print $form->end('Entrar');
	?>
	
</div>