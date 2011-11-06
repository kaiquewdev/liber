
<h2 class="descricao_cabecalho">Exibindo as cargas cadastradas</h2>

<?php print $this->element('painel_index'); ?>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Criada em','data_hora_criada'); ?></th>
			<th><?php print $paginator->sort('Situacao','situacao'); ?></th>
			<th><?php print $paginator->sort('Usuário que criou','usuario_cadastrou'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta_conta as $carga): ?>
		
		<tr>
			<td><?php print $carga['Carga']['id'];?></td>
			<td><?php print $html->link($carga['Carga']['data_hora_criada'],'editar/' . $carga['Carga']['id']) ;?></td>
			<td><?php print $carga['Carga']['situacao']; ?></td>
			<td><?php print $carga['Carga']['usuario_cadastrou']; ?></td>
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$carga['Carga']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$carga['Carga']['id']))) ?></td>
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
