
<h2 class="descricao_cabecalho">Exibindo plano de contas</h2>

<?php print $this->element('painel_index'); ?>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Nome','nome'); ?></th>
			<th><?php print $paginator->sort('Tipo','tipo'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta_plano_contas as $consulta): ?>
		
		<tr>
			<td><?php print $consulta['PlanoConta']['id'];?></td>
			<td><?php print $html->link($consulta['PlanoConta']['nome'],'editar/' . $consulta['PlanoConta']['id']) ;?></td>
			<td>
				<?php
				switch ($consulta['PlanoConta']['tipo']) {
					case 'R':
						print 'Receitas';
						break;
					case 'D':
						print 'Despesas';
						break;
					case 'E':
						print 'Especiais';
						break;
					default:
						print 'Não informado';
						break;
				}
				?>
			</td>
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$consulta['PlanoConta']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$consulta['PlanoConta']['id']))) ?></td>
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
