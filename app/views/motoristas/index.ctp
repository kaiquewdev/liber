
<h2 class="descricao_cabecalho">Exibindo os motoristas cadastrados</h2>

<?php print $this->element('painel_index'); ?>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Nome','nome'); ?></th>
			<th><?php print $paginator->sort('CNH - categoria','cnh_categoria'); ?></th>
			<th><?php print $paginator->sort('Veículo padrão','veiculo_padrao'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta_motorista as $c): ?>
		
		<tr>
			<td><?php print $c['Motorista']['id'];?></td>
			<td><?php print $html->link($c['Motorista']['nome'],'editar/' . $c['Motorista']['id']) ;?></td>
			<td><?php print $c['Motorista']['cnh_categoria']; ?></td>
			<td><?php print $c['Motorista']['veiculo_padrao'].' '.$c['Veiculo']['modelo']; ?></td>
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$c['Motorista']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$c['Motorista']['id']))) ?></td>
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
