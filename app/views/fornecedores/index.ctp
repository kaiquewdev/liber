
<h2 class="descricao_cabecalho">Exibindo todos os fornecedores cadastrados</h2>

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
			<th><?php print $paginator->sort('Cód','id'); ?></th>
			<th><?php print $paginator->sort('Tipo','tipo_pessoa'); ?></th>
			<th><?php print $paginator->sort('Nome','nome'); ?></th>
			<th>CNPJ/CPF</th>
			<th>I.E/RG</th>
			<th><?php print $paginator->sort('Logradouro','logradouro_nome'); ?></th>
			<th><?php print $paginator->sort('Número','logradouro_numero'); ?></th>
			<th><?php print $paginator->sort('Comp.','logradouro_complemento'); ?></th>
			<th><?php print $paginator->sort('Bairro','bairro'); ?></th>
			<th><?php print $paginator->sort('Cidade','cidade'); ?></th>
			<th><?php print $paginator->sort('Celular','numero_telefone'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta_fornecedor as $c):
	$tipo = strtoupper($c['Fornecedor']['tipo_pessoa']);
	if ($tipo == 'J') $tipo = 'JURIDICA';
	else $tipo = 'FISICA';
	?>
		
		<tr>
			<td><?php print $c['Fornecedor']['id'];?></td>
			<td><?php print $tipo; ?></td>
			<td><?php print $html->link($c['Fornecedor']['nome'],'editar/' . $c['Fornecedor']['id']) ;?></td>
			<td>
				<?php
				if ($tipo == 'JURIDICA') print $c['Fornecedor']['cnpj'];
				else print $c['Fornecedor']['cpf'];
				?>
			</td>
			<td>
				<?php
				if ($tipo == 'JURIDICA') print $c['Fornecedor']['inscricao_estadual'];
				else print $c['Fornecedor']['rg']; 
				?>
			</td>
			<td><?php print $c['Fornecedor']['logradouro_nome'];?></td>
			<td><?php print $c['Fornecedor']['logradouro_numero'];?></td>
			<td><?php print $c['Fornecedor']['logradouro_complemento'];?></td>
			<td><?php print $c['Fornecedor']['bairro'];?></td>
			<td><?php print $c['Fornecedor']['cidade'];?></td>
			<td><?php print $c['Fornecedor']['numero_telefone'];?></td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$c['Fornecedor']['id']))) ?></td>
			<td><?php print $html->image('detalhar24x24.png',array('title'=>'Detalhar',
			'alt'=>'Detalhar','url'=>array('action'=>'detalhar',$c['Fornecedor']['id']))) ?></td>
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
