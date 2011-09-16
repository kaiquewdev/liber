<h2 class="descricao_cabecalho">Pesquisar produto</h2>

<?php
/**
 * Elimino as divs dos campos input para que nao apareça quais campos
 * sao marcados como obrigatorios no BD, pois aqui isso non ecxiste
 */
print $form->create(null,array('controller'=>'produtos','action'=>'pesquisar','autocomplete'=>'off'));
?>
<div class="divs_grupo_2">
	
	<div class="div1_2">
		<?php
		print '<div>'.$form->input('nome', array('label'=>'Nome','div'=>false)).'</div>';
		print '<div>'.$form->input('categoria_produto_id', array('label'=>'Categoria','div'=>false,'options'=>$opcoes_categoria_produto)).'</div>';
		print '<div>'.$form->input('tipo_produto',array('div'=>false,'label'=>'Tipo','options'=>array(''=>''))).'</div>';
		print '<div>'.$form->input('codigo_ean',array('div'=>false,'label'=>'Código EAN')).'</div>';
		?>
	</div>
	
	<div class="div2_2">
		<?php
		print '<div>'.$form->input('codigo_dun',array('label'=>'Código DUN','div'=>false)).'</div>';
		print '<div>'.$form->input('unidade',array('label'=>'Unidade','div'=>false)).'</div>';
		print '<div>'.$form->input('quantidade_estoque_fiscal',array('label'=>'Qtd. estoque fiscal','div'=>false)).'</div>';
		print '<div>'.$form->input('situacao',array('label'=>'Situação','div'=>false)).'</div>';
		?>
	</div>
	
	<?php
	print $form->end('Pesquisar');	
	?>
	
</div>

<?php if (isset($num_resultados) && $num_resultados > 0) : ?>
	<table class="resultados">
		<thead>
			<tr>
				<th><?php print $paginator->sort('Cód','id'); ?></th>
				<th><?php print $paginator->sort('Nome','nome'); ?></th>
				<th><?php print $paginator->sort('Categoria','categoria_produto_id'); ?></th>
				<th><?php print $paginator->sort('Tipo produto','tipo_produto'); ?></th>
				<th><?php print $paginator->sort('Preço de custo','preco_custo'); ?></th>
				<th><?php print $paginator->sort('Preço de venda','preco_venda'); ?></th>
				<th><?php print $paginator->sort('Unidade','quantidade_estoque_fiscal'); ?></th>
				<th><?php print $paginator->sort('Situação','situacao'); ?></th>
				<th colspan="2">Ações</th>
			</tr>
		</thead>
		
		<tbody>
			<?php foreach ($resultados as $r) : ?>
				<tr>
					<td><?php print $r['Produto']['id']; ?></td>
					<td><?php print $html->link($r['Produto']['nome'],'editar/' . $r['Produto']['id']) ;?></td>
					<td><?php print $r['Produto']['categoria_produto_id'].' '.$r['CategoriaProduto']['nome']; ?></td>
					<td><?php print $r['Produto']['tipo_produto']; ?></td>
					<td><?php print $r['Produto']['preco_custo']; ?></td>
					<td><?php print $r['Produto']['preco_venda']; ?></td>
					<td><?php print $r['Produto']['quantidade_estoque_fiscal']; ?></td>
					<td><?php print $r['Produto']['situacao']; ?></td>
					<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
					'alt'=>'Editar','url'=>array('action'=>'editar',$r['Produto']['id']))) ?></td>
					<td><?php print $html->image('detalhar24x24.png',array('title'=>'Detalhar',
					'alt'=>'Detalhar','url'=>array('action'=>'detalhar',$r['Produto']['id']))) ?></td>
				</tr>
			<?php endforeach; ?>
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
	
<?php endif; ?>
