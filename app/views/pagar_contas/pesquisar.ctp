<h2 class="descricao_cabecalho">Pesquisar conta a pagar</h2>

<?php
/**
 * Elimino as divs dos campos input para que nao apareça quais campos
 * sao marcados como obrigatorios no BD, pois aqui isso non ecxiste
 */
print $form->create(null,array('action'=>'pesquisar','autocomplete'=>'off'));
?>
<div id="divs_grupo_2">
	
	<div id="div1_2">
		<?php
		
		print '<div>'.$form->input('numero_documento',array('label'=>'Número do documento','div'=>false)).'</div>';
		print '<div>'.$form->input('valor',array('label'=>'Valor','div'=>false)).'</div>';
		print '<div>'.$form->input('eh_cliente_ou_fornecedor', array('label'=>'Cliente ou fornecedor?',
		'div'=>false,'options'=>array(''=>'','C'=>'Cliente','F'=>'Fornecedor'))).'</div>';
		print '<div>'.$form->input('cliente_fornecedor_id',array('label'=>'Código cliente/fornecedor','div'=>false,'type'=>'text')).'</div>';
		?>
	</div>
	
	<div id="div2_2">
		<?php
		print '<div>'.$form->input('id', array('label'=>'Código','div'=>false)).'</div>';
		print '<div>'.$form->input('tipo_documento_id',array('label'=>'Tipo do documento','div'=>false,'options'=>$opcoes_tipo_documento)).'</div>';
		print '<div>'.$form->input('conta_origem',array('label'=>'Conta de origem','div'=>false,'options'=>$opcoes_conta_origem)).'</div>';
		print '<div>'.$form->input('plano_conta_id',array('label'=>'Plano de contas','div'=>false,'options'=>$opcoes_plano_contas)).'</div>';
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
				<th><?php print $paginator->sort('Cliente ou fornecedor?','eh_cliente_ou_fornecedor'); ?></th>
				<th><?php print $paginator->sort('Cliente/fornecedor','cliente_fornecedor_id'); ?></th>
				<th><?php print $paginator->sort('Tipo documento','tipo_documento_id'); ?></th>
				<th><?php print $paginator->sort('Número documento','numero_documento'); ?></th>
				<th><?php print $paginator->sort('Valor','valor'); ?></th>
				<th><?php print $paginator->sort('Conta origem','conta_origem'); ?></th>
				<th><?php print $paginator->sort('Plano de contas','plano_conta_id'); ?></th>
				<th colspan="2">Ações</th>
			</tr>
		</thead>
		
		<tbody>
			<?php foreach ($resultados as $r) :
				if (strtoupper($r['PagarConta']['eh_cliente_ou_fornecedor']) == 'C') $tipo='cliente';
				else $tipo='fornecedor';
				?>
				<tr>
					<td><?php print $r['PagarConta']['id']; ?></td>
					<td><?php print ucfirst($tipo); ?></td>
					<td>
						<?php
						if ($tipo == 'cliente') print $html->link($r['Cliente']['nome'],'editar/' . $r['PagarConta']['id']) ;
						else if ($tipo == 'fornecedor') print $html->link($r['Fornecedor']['nome'],'editar/' . $r['PagarConta']['id']) ;
						?>
					</td>
					<td><?php print $r['PagarConta']['tipo_documento_id'].' '.$r['TipoDocumento']['nome']; ?></td>
					<td><?php print $r['PagarConta']['numero_documento']; ?></td>
					<td><?php print $r['PagarConta']['valor'] ?></td>
					<td><?php print $r['PagarConta']['conta_origem'].' '.$r['Conta']['nome'] ?></td>
					<td><?php print $r['PagarConta']['plano_conta_id'].' '.$r['PlanoConta']['nome'] ; ?></td>
					<td>
						<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
						href="'.$html->url(array('action'=>'excluir')).'/'.$r['PagarConta']['id'].'">'.
						$html->image('del24x24.png', array('alt'=>'Excluir'))
						.'</a>';?>
					</td>
					<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
					'alt'=>'Editar','url'=>array('action'=>'editar',$r['PagarConta']['id']))) ?></td>
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
