
<h2 class="descricao_cabecalho">Exibindo todas as empresas cadastradas</h2>

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
			<th><?php print $paginator->sort('Nome','nome'); ?></th>
			<th><?php print $paginator->sort('CNPJ','cnpj'); ?></th>
			<th><?php print $paginator->sort('Logroudouro','logradouro'); ?></th>
			<th><?php print $paginator->sort('Número','numero'); ?></th>
			<th><?php print $paginator->sort('Bairro','bairro'); ?></th>
			<th><?php print $paginator->sort('Complemento','complemento'); ?></th>
			<th><?php print $paginator->sort('Cidade','cidade'); ?></th>
			<th><?php print $paginator->sort('Estado','estado'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta_empresa as $c): ?>
		
		<tr>
			<td><?php print $c['Empresa']['id'];?></td>
			<td><?php print $html->link($c['Empresa']['nome'],'editar/' . $c['Empresa']['id']) ;?></td>
			<td> <?php print $c['Empresa']['cnpj']; ?> </td>
			<td><?php print $c['Empresa']['logradouro']; ?></td>
			<td><?php print $c['Empresa']['numero']; ?></td>
			<td><?php print $c['Empresa']['bairro']; ?></td>
			<td><?php print $c['Empresa']['complemento']; ?></td>
			<td><?php print $c['Empresa']['cidade']; ?></td>
			<td><?php print $c['Empresa']['estado']; ?></td>
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$c['Empresa']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$c['Empresa']['id']))) ?></td>
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
