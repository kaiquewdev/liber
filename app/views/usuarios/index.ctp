
<h2 class="descricao_cabecalho">Exibindo todos os usuários cadastrados</h2>

<div id="botoes">
	<?php print $html->image('add24x24.png',array('title'=>'Cadastrar',
		'alt'=>'Cadastrar','url'=>array('action'=>'cadastrar')));
	print '<a title="Imprimir" onclick="javascript: window.print();" href="#">'.
		$html->image('print24x24.png', array('alt'=>'Imprimir')).'</a>';
	?>
</div>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Cód','id'); ?></th>
			<th><?php print $paginator->sort('Nome','nome'); ?></th>
			<th><?php print $paginator->sort('Login','login'); ?></th>
			<th><?php print $paginator->sort('Permissão','permissao'); ?></th>
			<th><?php print $paginator->sort('Ativo','ativo'); ?></th>
			<th><?php print $paginator->sort('E-mail','email'); ?></th>
			<th><?php print $paginator->sort('Último login','ultimo_login'); ?></th>
			<th><?php print $paginator->sort('Último logout','ultimo_logout'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta_usuario as $usuario): ?>
		
		<tr>
			<td><?php print $usuario['Usuario']['id'];?></td>
			<td><?php print $html->link($usuario['Usuario']['nome'],'editar/' . $usuario['Usuario']['id']) ;?></td>
			<td><?php print $usuario['Usuario']['login']; ?></td>
			<td><?php print $usuario['Usuario']['permissao']; ?></td>
			<td>
				<?php
				if ($usuario['Usuario']['ativo'] == 1) print "Sim";
				else print "Não";
				?>
			</td>
			<td><?php print $usuario['Usuario']['email']; ?></td>
			<td><?php print $usuario['Usuario']['ultimo_login']; ?></td>
			<td><?php print $usuario['Usuario']['ultimo_logout']; ?></td>
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$usuario['Usuario']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$usuario['Usuario']['id']))) ?></td>
		</tr>

<?php endforeach ?>

	</tbody>
</table>

<?php
print $paginator->counter(array(
	'format' => 'Exibindo %current% registros de um total de %count% registros. Página %page% de %pages%.'
)); 

print '<br/>';

print $paginator->prev('« Anterior ', null, null, array('class' => 'disabled'));
print $paginator->next(' Próximo »', null, null, array('class' => 'disabled'));

?>
