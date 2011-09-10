<h2 class="descricao_cabecalho">Pesquisar cliente</h2>

<?php
/**
 * Elimino as divs dos campos input para que nao apareça quais campos
 * sao marcados como obrigatorios no BD, pois aqui isso non ecxiste
 */
print $form->create(null,array('controller'=>'clientes','action'=>'pesquisar','autocomplete'=>'off'));
?>
<div id="divs_grupo_2">
	
	<div id="div1_2">
		<?php
		print '<div>'.$form->input('nome', array('label'=>'Nome','div'=>false)).'</div>';
		print '<div>'.$form->input('nome_fantasia', array('label'=>'Nome fantasia','div'=>false)).'</div>';
		print '<div>'.$form->input('bairro',array('div'=>false)).'</div>';
		print '<div>'.$form->input('cidade',array('div'=>false)).'</div>';
		?>
	</div>
	
	<div id="div2_2">
		<?php
		print '<div>'.$form->input('cnpj',array('label'=>'CNPJ','div'=>false)).'</div>';
		print '<div>'.$form->input('inscricao_estadual',array('label'=>'Inscrição estadual','div'=>false)).'</div>';
		print '<div>'.$form->input('cpf',array('label'=>'CPF','div'=>false)).'</div>';
		print '<div>'.$form->input('rg',array('label'=>'RG','div'=>false)).'</div>';
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
				<th><?php print $paginator->sort('Pessoa','tipo_pessoa'); ?></th>
				<th><?php print $paginator->sort('Nome','nome'); ?></th>
				<th><?php print $paginator->sort('Nome fantasia','nome_fantasia'); ?></th>
				<th><?php print $paginator->sort('Cidade','cidade'); ?></th>
				<th>CPF/CNPJ</th>
				<th>RG/IE</th>
				<th><?php print $paginator->sort('Usuário cadastrou','usuario_cadastrou'); ?></th>
				<th colspan="2">Ações</th>
			</tr>
		</thead>
		
		<tbody>
			<?php foreach ($resultados as $r) : ?>
				<tr>
					<td><?php print $r['Cliente']['id']; ?></td>
					<td><?php print $r['Cliente']['tipo_pessoa']; ?></td>
					<td><?php print $html->link($r['Cliente']['nome'],'editar/' . $r['Cliente']['id']) ;?></td>
					<td><?php print $r['Cliente']['nome_fantasia']; ?></td>
					<td><?php print $r['Cliente']['cidade']; ?></td>
					<td><?php print $r['Cliente']['cpf'].$r['Cliente']['cnpj']; ?></td>
					<td><?php print $r['Cliente']['rg'].$r['Cliente']['inscricao_estadual']; ?></td>
					<td><?php print $r['Usuario']['login']; ?></td>
					<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
					'alt'=>'Editar','url'=>array('action'=>'editar',$r['Cliente']['id']))) ?></td>
					<td><?php print $html->image('detalhar24x24.png',array('title'=>'Detalhar',
					'alt'=>'Detalhar','url'=>array('action'=>'detalhar',$r['Cliente']['id']))) ?></td>
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
