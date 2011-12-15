
<h2 class="descricao_cabecalho">Exibindo as contas a receber</h2>

<?php print $this->element('painel_index'); ?>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Cliente ou fornecedor?','eh_cliente_ou_fornecedor'); ?></th>
			<th><?php print $paginator->sort('Cliente / fornecedor','cliente_fornecedor_id'); ?></th>
			<th><?php print $paginator->sort('Documento','tipo_documento_id'); ?></th>
			<th><?php print $paginator->sort('N. documento','numero_documento'); ?></th>
			<th><?php print $paginator->sort('Valor','valor'); ?></th>
			<th><?php print $paginator->sort('Situação','situacao'); ?></th>
			<th><?php print $paginator->sort('Plano de contas','plano_conta_id'); ?></th>
			<th><?php print $paginator->sort('Vencimento','data_vencimento'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta_conta_pagar as $c):
	if (strtoupper($c['PagarConta']['eh_cliente_ou_fornecedor']) == 'C') $tipo = 'cliente';
	else $tipo = 'fornecedor';
?>
		
		<tr>
			<td><?php print $c['PagarConta']['id'];?></td>
			<td><?php print ucfirst($tipo); ?></td>
			<td>
				<?php
				print $c['PagarConta']['cliente_fornecedor_id'].' ';
				if ($tipo == 'cliente') print $html->link($c['Cliente']['nome'],'editar/'.$c['PagarConta']['id']);
				else if ($tipo == 'fornecedor') print $html->link($c['Fornecedor']['nome'],'editar/'.$c['PagarConta']['id']);
				?>
			</td>
			<td><?php print $c['PagarConta']['tipo_documento_id'].' '.$c['TipoDocumento']['nome']; ?></td>
			<td><?php print $c['PagarConta']['numero_documento']; ?></td>
			<td><?php print $c['PagarConta']['valor']; ?></td>
			<td><?php print $opcoes_situacoes[$c['PagarConta']['situacao']] ?></td>
			<td><?php print $c['PagarConta']['plano_conta_id'].' '.$c['PlanoConta']['nome']; ?></td>
			<td><?php print $formatacao->data($c['PagarConta']['data_vencimento']); ?></td>
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$c['PagarConta']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$c['PagarConta']['id']))) ?></td>
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
