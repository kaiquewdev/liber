
<h2 class="descricao_cabecalho">Exibindo as ordens de serviço cadastradas</h2>

<?php print $this->element('painel_index'); ?>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Cadastrada','data_hora_cadastrada'); ?></th>
			<th><?php print $paginator->sort('Cliente','cliente_id'); ?></th>
			<th><?php print $paginator->sort('Usuário cadastrou','usuario_id'); ?></th>
			<th><?php print $paginator->sort('Situação','situacao'); ?></th>
			<th><?php print $paginator->sort('Início','data_hora_inicio'); ?></th>
			<th><?php print $paginator->sort('Fim','data_hora_fim'); ?></th>
			<th><?php print $paginator->sort('Valor bruto','valor_bruto'); ?></th>
			<th><?php print $paginator->sort('Valor líquido','valor_liquido'); ?></th>
			<th colspan="3">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php
$s = array(
'O' => 'Orçamento',
'E' => 'Em espera',
'X' => 'Em execução',
'F' => 'Finalizada',
'E' => 'Entregue',
'C' => 'Cancelada');
foreach ($consulta as $c): ?>
		
		<tr>
			<td><?php print $c['ServicoOrdem']['id'];?></td>
			<td><?php print $html->link($formatacao->dataHora($c['ServicoOrdem']['data_hora_cadastrada']),'editar/' . $c['ServicoOrdem']['id']) ;?></td>
			<td><?php print $c['ServicoOrdem']['cliente_id'].' '.$c['Cliente']['nome']; ?></td>
			<td><?php print $c['ServicoOrdem']['usuario_id'].' '.$c['Usuario']['nome']; ?></td>
			<td><?php print $s[$c['ServicoOrdem']['situacao']]; ?></td>
			<td><?php print $formatacao->dataHora($c['ServicoOrdem']['data_hora_inicio']); ?></td>
			<td><?php if (!empty($c['ServicoOrdem']['data_hora_fim'])) print $formatacao->dataHora($c['ServicoOrdem']['data_hora_fim']); ?></td>
			<td><?php print $c['ServicoOrdem']['valor_bruto']; ?></td>
			<td><?php print $c['ServicoOrdem']['valor_liquido']; ?></td>
			
			<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
			'alt'=>'Editar','url'=>array('action'=>'editar',$c['ServicoOrdem']['id']))) ?></td>
			
			<td><?php print $html->image('detalhar24x24.png',array('title'=>'Detalhar',
			'alt'=>'Detalhar','url'=>array('action'=>'detalhar',$c['ServicoOrdem']['id']))) ?></td>
			
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$c['ServicoOrdem']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
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
