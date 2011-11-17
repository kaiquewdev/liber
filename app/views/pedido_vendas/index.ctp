
<h2 class="descricao_cabecalho">Exibindo os pedidos de venda</h2>

<?php print $this->element('painel_index'); ?>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Cliente','cliente_id'); ?></th>
			<th><?php print $paginator->sort('Forma de pagamento','forma_pagamento_id'); ?></th>
			<th><?php print $paginator->sort('Data venda','data_venda'); ?></th>
			<th><?php print $paginator->sort('Valor bruto','valor_bruto'); ?></th>
			<th><?php print $paginator->sort('Valor líquido','valor_liquido'); ?></th>
			<th><?php print $paginator->sort('Situação','situacao'); ?></th>
			<th colspan="3">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php
$s = array(
'A' => 'Aberto',
'O' => 'Orçamento',
'C' => 'Cancelado',
'V' => 'Vendido');

foreach ($consulta as $c): ?>
		
		<tr>
			<td><?php print $c['PedidoVenda']['id'];?></td>
			<td><?php print $c['PedidoVenda']['cliente_id'].' '.$c['Cliente']['nome']; ?></td>
			<td><?php print $c['PedidoVenda']['forma_pagamento_id'].' '.$c['FormaPagamento']['nome']; ?></td>
			<td><?php if(isset($c['PedidoVenda']['data_venda']) && ($c['PedidoVenda']['data_venda'] != '0000-00-00') ) print $formatacao->data($c['PedidoVenda']['data_venda']); ?></td>
			<td><?php print $c['PedidoVenda']['valor_bruto']; ?></td>
			<td><?php print $c['PedidoVenda']['valor_liquido']; ?></td>
			<td><?php print $s[$c['PedidoVenda']['situacao']]; ?></td>
			
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$c['PedidoVenda']['id']))) ?></td>
			
			<td><?php print $html->image('detalhar24x24.png',array('title'=>'Detalhar',
			'alt'=>'Detalhar','url'=>array('action'=>'detalhar',$c['PedidoVenda']['id']))) ?></td>
			
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$c['PedidoVenda']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
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
