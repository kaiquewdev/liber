
<h2 class="descricao_cabecalho">Exibindo todas as ordens de serviço cadastradas</h2>

<div class="botoes">
	<?php print $html->image('add24x24.png',array('title'=>'Cadastrar',
		'alt'=>'Cadastrar','url'=>array('action'=>'cadastrar')));
	print '<a title="Imprimir" onclick="javascript: window.print();" href="#">'.
		$html->image('print24x24.png', array('alt'=>'Imprimir')).'</a>';
	?>
</div>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Cadastrada','data_hora_cadastrada'); ?></th>
			<th><?php print $paginator->sort('Cliente','cliente_id'); ?></th>
			<th><?php print $paginator->sort('Usuário cadastrou','usuario_id'); ?></th>
			<th><?php print $paginator->sort('Situação','situacao'); ?></th>
			<th><?php print $paginator->sort('Fim','data_hora_fim'); ?></th>
			<th><?php print $paginator->sort('Laudo técnico','laudo_tecnico'); ?></th>
			<th colspan="1">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta as $c): ?>
		
		<tr>
			<td><?php print $c['ServicoOrdem']['id'];?></td>
			<td><?php print $html->link($c['ServicoOrdem']['data_hora_cadastrada'],'editar/' . $c['ServicoOrdem']['id']) ;?></td>
			<td><?php print $c['ServicoOrdem']['cliente_id'].' '.$c['Cliente']['nome']; ?></td>
			<td><?php print $c['ServicoOrdem']['usuario_id'].' '.$c['Usuario']['nome']; ?></td>
			<td><?php print $c['ServicoOrdem']['situacao']; ?></td>
			<td><?php print $c['ServicoOrdem']['data_hora_fim']; ?></td>
			<td><?php print $c['ServicoOrdem']['laudo_tecnico']; ?></td>
			
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$c['ServicoOrdem']['id']))) ?></td>
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
