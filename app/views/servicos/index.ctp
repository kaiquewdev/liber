
<h2 class="descricao_cabecalho">Exibindo os serviços cadastrados</h2>

<?php print $this->element('painel_index'); ?>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Nome','nome'); ?></th>
			<th><?php print $paginator->sort('Categoria','servico_categoria_id'); ?></th>
			<th><?php print $paginator->sort('Valor','valor'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta as $c): ?>
		
		<tr>
			<td><?php print $c['Servico']['id'];?></td>
			<td><?php print $html->link($c['Servico']['nome'],'editar/' . $c['Servico']['id']) ;?></td>
			<td><?php print $c['Servico']['servico_categoria_id'].' '.$c['ServicoCategoria']['nome']; ?></td>
			<td><?php print $c['Servico']['valor']; ?></td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$c['Servico']['id']))) ?></td>
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$c['Servico']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
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
