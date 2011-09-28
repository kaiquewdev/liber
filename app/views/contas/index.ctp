
<h2 class="descricao_cabecalho">Exibindo todas as contas cadastradas</h2>

<?php print $this->element('painel_index'); ?>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Nome','nome'); ?></th>
			<th><?php print $paginator->sort('Apelido','apelido'); ?></th>
			<th><?php print $paginator->sort('Banco','banco'); ?></th>
			<th><?php print $paginator->sort('Agência','agencia'); ?></th>
			<th><?php print $paginator->sort('Conta','conta'); ?></th>
			<th><?php print $paginator->sort('Titular','titular'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta_conta as $conta): ?>
		
		<tr>
			<td><?php print $conta['Conta']['id'];?></td>
			<td><?php print $html->link($conta['Conta']['nome'],'editar/' . $conta['Conta']['id']) ;?></td>
			<td><?php print $conta['Conta']['apelido']; ?></td>
			<td><?php print $conta['Conta']['banco']; ?></td>
			<td><?php print $conta['Conta']['agencia']; ?></td>
			<td><?php print $conta['Conta']['conta']; ?></td>
			<td><?php print $conta['Conta']['titular']; ?></td>
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$conta['Conta']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$conta['Conta']['id']))) ?></td>
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
