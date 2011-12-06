<div class="botoes">
	<?php print $html->image('add24x24.png',array('title'=>'Cadastrar',
		'alt'=>'Cadastrar','url'=>array('action'=>'cadastrar')));
	print '<a title="Imprimir" onclick="javascript: window.print();" href="#">'.
		$html->image('print24x24.png', array('alt'=>'Imprimir')).'</a>';
	?>
</div>