
<h2 class="descricao_cabecalho">Exibindo os carregamentos cadastrados</h2>

<?php print $this->element('painel_index'); ?>

<table>
	<thead>
		<tr>
			<th><?php print $paginator->sort('Código','id'); ?></th>
			<th><?php print $paginator->sort('Criado em','data_hora_criado'); ?></th>
			<th><?php print $paginator->sort('Descrição','descricao'); ?></th>
			<th><?php print $paginator->sort('Situação','situacao'); ?></th>
			<th colspan="2">Ações</th>
		</tr>
	</thead>
	
	<tbody>
		
<?php foreach ($consulta as $carregamento): ?>
		
		<tr>
			<td><?php print $carregamento['Carregamento']['id'];?></td>
			<td><?php print $html->link($formatacao->dataHora($carregamento['Carregamento']['data_hora_criado']),'editar/' . $carregamento['Carregamento']['id']) ;?></td>
			<td><?php print $carregamento['Carregamento']['descricao']; ?></td>
			<td><?php print $opcoes_situacoes[$carregamento['Carregamento']['situacao']]; ?></td>
			<td>
				<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
				href="'.$html->url(array('action'=>'excluir')).'/'.$carregamento['Carregamento']['id'].'">'.
				$html->image('del24x24.png', array('alt'=>'Excluir'))
				.'</a>';?>
			</td>
			<td>
				<?php print $html->image('detalhar24x24.png',array('title'=>'Detalhar',
				'alt'=>'Detalhar','url'=>array('action'=>'detalhar',$carregamento['Carregamento']['id']))) ?>
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
