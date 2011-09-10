
<h2 class="descricao_cabecalho">Exibindo todos os tipos de documentos cadastrados</h2>

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
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Nome','nome'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta_tipo_documento as $consulta): ?>
		
		<tr>
			<td><?php print $consulta['TipoDocumento']['id'];?></td>
			<td><?php print $html->link($consulta['TipoDocumento']['nome'],'editar/' . $consulta['TipoDocumento']['id']) ;?></td>
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$consulta['TipoDocumento']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$consulta['TipoDocumento']['id']))) ?></td>
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
