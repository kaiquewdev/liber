
<h2 class="descricao_cabecalho">Exibindo todos as formas de pagamento cadastradas</h2>

<?php print $this->element('painel_index'); ?>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Nome','nome'); ?></th>
			<th><?php print $paginator->sort('Num. máximo de parcelas','numero_maximo_parcelas'); ?></th>
			<th><?php print $paginator->sort('Num. máximo de parcelas s/ juros','numero_parcelas_sem_juros'); ?></th>
			<th><?php print $paginator->sort('Dias de intervalo do parcelamento','dias_intervalo_parcelamento'); ?></th>
			<th><?php print $paginator->sort('Porcentagem de juros','porcentagem_juros'); ?></th>
			<th><?php print $paginator->sort('Valor mínimo por parcela','valor_minimo_parcela'); ?></th>
			<th><?php print $paginator->sort('Porcentagem de desconto a vista','porcentagem_desconto_a_vista'); ?></th>
			<th><?php print $paginator->sort('Conta principal','conta_pricipal'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta_forma_pagamento as $consulta): ?>
		
		<tr>
			<td><?php print $consulta['FormaPagamento']['id'];?></td>
			<td><?php print $html->link($consulta['FormaPagamento']['nome'],'editar/' . $consulta['FormaPagamento']['id']) ;?></td>
			<td><?php print $consulta['FormaPagamento']['numero_maximo_parcelas']; ?></td>
			<td><?php print $consulta['FormaPagamento']['numero_parcelas_sem_juros']; ?></td>
			<td><?php print $consulta['FormaPagamento']['dias_intervalo_parcelamento']; ?></td>
			<td><?php print $consulta['FormaPagamento']['porcentagem_juros']; ?></td>
			<td><?php print $consulta['FormaPagamento']['valor_minimo_parcela']; ?></td>
			<td><?php print $consulta['FormaPagamento']['porcentagem_desconto_a_vista']; ?></td>
			<td><?php print $consulta['FormaPagamento']['conta_principal'].' '.
			$consulta['Conta']['nome']; ?></td>
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$consulta['FormaPagamento']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$consulta['FormaPagamento']['id']))) ?></td>
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
