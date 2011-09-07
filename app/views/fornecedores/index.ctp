
<h2 class="descricao_cabecalho">Exibindo todos os clientes cadastrados</h2>

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
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta_cliente as $cliente): ?>
		
		<tr>
			<td><?php print $cliente['Fornecedor']['id'];?></td>
			<td><?php print $cliente['Fornecedor']['tipo_pessoa']; ?></td>
			<td><?php print $html->link($cliente['Fornecedor']['nome'],'detalhar/' . $cliente['Fornecedor']['id']) ;?></td>
			<td><?php print $cliente['Fornecedor']['logradouro_nome'];?></td>
			<td><?php print $cliente['Fornecedor']['logradouro_numero'];?></td>
			<td><?php print $cliente['Fornecedor']['logradouro_complemento'];?></td>
			<td><?php print $cliente['Fornecedor']['bairro'];?></td>
			<td><?php print $cliente['Fornecedor']['cidade'];?></td>
			<td><?php print $cliente['Fornecedor']['numero_telefone'];?></td>
			<td><?php print $cliente['Fornecedor']['numero_celular'];?></td>
			<td><?php print $cliente['Fornecedor']['endereco_email'];?></td>
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
