<script type="text/javascript">
		$(function(){
			$(".datepicker").datepicker({
				showOn: "button",
				buttonImage: "<?php print $html->url('/',true); ?>/img/calendario_icone.gif",
				buttonImageOnly: true
			});
	
		});
</script>
<h2 class="descricao_cabecalho">Pesquisar carregamento</h2>

<?php
array_unshift($opcoes_situacoes,array(''=>''));
array_unshift($opcoes_motoristas,array(''=>''));
array_unshift($opcoes_veiculos,array(''=>''));
/**
 * Elimino as divs dos campos input para que nao apareça quais campos
 * sao marcados como obrigatorios no BD, pois aqui isso non ecxiste
 */
print $form->create(null,array('controller'=>'carregamentos','action'=>'pesquisar','autocomplete'=>'off'));
?>
<div class="divs_grupo_2">
	
	<div class="div1_2">
		<?php
		print '<div>'.$form->input('data_inicial', array('label'=>'Data Inicial','div'=>false,'class'=>'datepicker mascara_data')).'</div>';
		print '<div>'.$form->input('data_final',array('div'=>false,'class'=>'datepicker mascara_data')).'</div>';
		print '<div>'.$form->input('situacao',array('div'=>false,'label'=>'Situação','options'=>$opcoes_situacoes)).'</div>';
		?>
	</div>
	
	<div class="div2_2">
		<?php
		print '<div>'.$form->input('descricao',array('label'=>'Descrição','div'=>false)).'</div>';
		print '<div>'.$form->input('motorista',array('label'=>'Motorista','div'=>false,'options'=>$opcoes_motoristas)).'</div>';
		print '<div>'.$form->input('veiculo',array('label'=>'Veículo','div'=>false,'options'=>$opcoes_veiculos)).'</div>';
		?>
	</div>

<div class="limpar">&nbsp;</div>

	<?php
	print $form->end('Pesquisar');	
	?>
	
</div>

<?php if (isset($num_resultados) && $num_resultados > 0) : ?>
	<table class="resultados">
		<thead>
			<tr>
				<th><?php print $paginator->sort('Cód','id'); ?></th>
				<th><?php print $paginator->sort('Criado em','data_hora_criado'); ?></th>
				<th><?php print $paginator->sort('Situação','situacao'); ?></th>
				<th><?php print $paginator->sort('Descrição','descricao'); ?></th>
				<th><?php print $paginator->sort('Motorista','motorista'); ?></th>
				<th><?php print $paginator->sort('Veículo','veiculo'); ?></th>
				<th colspan="2">Ações</th>
			</tr>
		</thead>
		
		<tbody>
			<?php foreach ($resultados as $r) : ?>
				<tr>
					<td><?php print $r['Carregamento']['id']; ?></td>
					<td><?php print $html->link($r['Carregamento']['data_hora_criado'],'editar/' . $r['Carregamento']['id']) ;?></td>
					<td><?php print $opcoes_situacoes[$r['Carregamento']['situacao']]; ?></td>
					<td><?php print $r['Carregamento']['descricao']; ?></td>
					<td><?php print $r['Motorista']['nome']; ?></td>
					<td><?php print $r['Veiculo']['placa']; ?></td>
					<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
					'alt'=>'Editar','url'=>array('action'=>'editar',$r['Carregamento']['id']))) ?></td>
					<td><?php print $html->image('detalhar24x24.png',array('title'=>'Detalhar',
					'alt'=>'Detalhar','url'=>array('action'=>'detalhar',$r['Carregamento']['id']))) ?></td>
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
