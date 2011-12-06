
<h2 class="descricao_cabecalho">Exibindo todos os produtos cadastrados</h2>

<?php print $this->element('painel_index'); ?>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Nome','nome'); ?></th>
			<th><?php print $paginator->sort('Categoria','categoria_produto_id'); ?></th>
			<th><?php print $paginator->sort('Preço de custo','preco_custo'); ?></th>
			<th><?php print $paginator->sort('Preço de venda','preco_venda'); ?></th>
			<th><?php print $paginator->sort('Margem de lucro','margem_lucro'); ?></th>
			<th><?php print $paginator->sort('Quantidade estoque fiscal','quantidade_estoque_fiscal'); ?></th>
			<th><?php print $paginator->sort('Quantidade estoque não fiscal','quantidade_estoque_nao_fiscal'); ?></th>
			<th colspan="1">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta as $c): ?>
		
		<tr>
			<td><?php print $c['Produto']['id'];?></td>
			<td><?php print $html->link($c['Produto']['nome'],'editar/' . $c['Produto']['id']) ;?></td>
			<td><?php print $c['CategoriaProduto']['nome']; ?></td>
			<td><?php print $c['Produto']['preco_custo']; ?></td>
			<td><?php print $c['Produto']['preco_venda']; ?></td>
			<td><?php print $c['Produto']['margem_lucro']; ?></td>
			<td><?php print $c['Produto']['quantidade_estoque_fiscal']; ?></td>
			<td><?php print $c['Produto']['quantidade_estoque_nao_fiscal']; ?></td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$c['Produto']['id']))) ?></td>
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
