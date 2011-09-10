
<h2 class="descricao_cabecalho">Exibindo todos os clientes cadastrados</h2>

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
			<th><?php print $paginator->sort('Tipo','tipo_pessoa'); ?></th>
			<th><?php print $paginator->sort('Nome','nome'); ?></th>
			<th><?php print $paginator->sort('Logradouro','logradouro_nome'); ?></th>
			<th><?php print $paginator->sort('Número','logradouro_numero'); ?></th>
			<th><?php print $paginator->sort('Comp.','logradouro_complemento'); ?></th>
			<th><?php print $paginator->sort('Bairro','bairro'); ?></th>
			<th><?php print $paginator->sort('Cidade','cidade'); ?></th>
			<th><?php print $paginator->sort('Telefone','numero_telefone'); ?></th>
			<th><?php print $paginator->sort('Celular','numero_celular'); ?></th>
			<th><?php print $paginator->sort('E-mail','endereco_email'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta_cliente as $cliente): ?>
		
		<tr>
			<td><?php print $cliente['Cliente']['id'];?></td>
			<td><?php print $cliente['Cliente']['tipo_pessoa']; ?></td>
			<td><?php print $html->link($cliente['Cliente']['nome'],'editar/' . $cliente['Cliente']['id']) ;?></td>
			<td><?php print $cliente['Cliente']['logradouro_nome'];?></td>
			<td><?php print $cliente['Cliente']['logradouro_numero'];?></td>
			<td><?php print $cliente['Cliente']['logradouro_complemento'];?></td>
			<td><?php print $cliente['Cliente']['bairro'];?></td>
			<td><?php print $cliente['Cliente']['cidade'];?></td>
			<td><?php print $cliente['Cliente']['numero_telefone'];?></td>
			<td><?php print $cliente['Cliente']['numero_celular'];?></td>
			<td><?php print $cliente['Cliente']['endereco_email'];?></td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$cliente['Cliente']['id']))) ?></td>
			<td><?php print $html->image('detalhar24x24.png',array('title'=>'Detalhar',
			'alt'=>'Detalhar','url'=>array('action'=>'detalhar',$cliente['Cliente']['id']))) ?></td>
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
