
<h2 class="descricao_cabecalho">Exibindo os veículos cadastrados</h2>

<?php print $this->element('painel_index'); ?>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Modelo','modelo'); ?></th>
			<th><?php print $paginator->sort('Placa','placa'); ?></th>
			<th><?php print $paginator->sort('Fabricante','fabricante'); ?></th>
			<th><?php print $paginator->sort('Ano','ano'); ?></th>
			<th><?php print $paginator->sort('Tipo','tipo'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta_veiculo as $veiculo): ?>
		
		<tr>
			<td><?php print $veiculo['Veiculo']['id'];?></td>
			<td><?php print $html->link($veiculo['Veiculo']['modelo'],'editar/' . $veiculo['Veiculo']['id']) ;?></td>
			<td><?php print $veiculo['Veiculo']['placa']; ?></td>
			<td><?php print $veiculo['Veiculo']['fabricante']; ?></td>
			<td><?php print $veiculo['Veiculo']['ano']; ?></td>
			<td><?php print $veiculo['Veiculo']['tipo']; ?></td>
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$veiculo['Veiculo']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$veiculo['Veiculo']['id']))) ?></td>
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
