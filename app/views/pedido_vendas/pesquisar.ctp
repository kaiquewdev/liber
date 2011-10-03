<?php
$javascript->link('formatar_moeda.js',false);
?>

<script type="text/javascript">
	$(function(){
		$(".datepicker").datepicker({
			showOn: "button",
			buttonImage: "<?php print $html->url('/',true); ?>/img/calendario_icone.gif",
			buttonImageOnly: true
		});
	
		$('#PedidoVendaValorTotal').priceFormat();
		
		//pesquisa cliente
		//autocomplete
		$("#PedidoVendaClienteNome").autocomplete({
			source: "<?php print $html->url('/',true); ?>/Clientes/pesquisaAjaxCliente/nome",
			minLength: 3,
			select: function(event, ui) {
				$("#PedidoVendaClienteId").val(ui.item.id);
				$('#PedidoVendaClienteNome').val(ui.item.nome);
			}
		});
		// ao digitar o codigo
		$('#PedidoVendaClienteId').blur(function(){
			codigo = $(this).val();
			if (codigo == null || codigo == '') return null;
			$.getJSON('<?php print $html->url('/',true); ?>/Clientes/pesquisaAjaxCliente/codigo', {'term': codigo}, function(data) {
				if (data == null) {
					alert ('Cliente com o código '+codigo+' não foi encontrado!');
					$('#PedidoVendaClienteNome').val('');
					$("#PedidoVendaClienteId")
						.val('')
						.focus();
				}
				else { //encontrou resultados
					data = data[0];
					$("#PedidoVendaClienteId").val(data.id);
					$('#PedidoVendaClienteNome').val(data.nome);
				}
			});
		});

	});
</script>

<h2 class="descricao_cabecalho">Pesquisar ordem de serviço</h2>

<?php
/**
 * Elimino as divs dos campos input para que nao apareça quais campos
 * sao marcados como obrigatorios no BD
 */
$s = array(
'O' => 'Orçamento',
'E' => 'Em espera',
'X' => 'Em execução',
'F' => 'Finalizada',
'E' => 'Entregue',
'C' => 'Cancelada');
print $form->create(null,array('controller'=>'servicoOrdens','action'=>'pesquisar','autocomplete'=>'off'));
?>
<div class="divs_grupo_2">
	
	<div class="div1_2">
		<div>
			<label>Código</label>
			<input id="PedidoVendaId" type="text" name="data[PedidoVenda][id]" class="" />
		</div>
		<div>
			<label>Cadastrada em</label>
			<input id="PedidoVendaDataHoraCadastrada" type="text" name="data[PedidoVenda][data_hora_cadastrada]" class="datepicker mascara_data" />
		</div>
		<div>
			<label>Início</label>
			<input type="text" id="PedidoVendaDataHoraInicio" name="data[PedidoVenda][data_hora_inicio]" class="datepicker macara-data"/>
		</div>
		<div>
			<label>Fim</label>
			<input type="text" id="PedidoVendaDataHoraFim" name="data[PedidoVenda][data_hora_fim]" class="datepicker mascara_data"/>
		</div>
		<div>
			<label>Valor total</label>
			<input type="text" id="PedidoVendaValorTotal" name="data[PedidoVenda][valor_total]"/>
		</div>
	</div>
	
	<div class="div2_2">
		<div>
			<label style="">Cliente</label>
			<input style="float:left; width: 10%;" id="PedidoVendaClienteId" type="text" name="data[PedidoVenda][cliente_id]" />
			<input style="margin-left: 1%; width: 80%" id="PedidoVendaClienteNome" type="text" name="data[PedidoVenda][cliente_nome]" />
		</div>
		<div>
			<label>Técnico</label>
			<select name="data[PedidoVenda][tecnico]">
				<?php foreach ($opcoes_tecnico as $chave => $valor)
					print "<option value='$chave'>$valor</option>";
				?>
			</select>
		</div>
		<div>
			<label>Situação</label>
			<select name="data[PedidoVenda][situacao]">
				<option value=""></option>
				<?php foreach ($s as $chave => $valor)
					print "<option value='$chave'>$valor</option>";
				?>
			</select>
		</div>
		<div>
			<label>Usuário cadastrou</label>
			<select name="data[PedidoVenda][usuario_cadastrou]" id="PedidoVendaUsuarioCadastrou">
				<?php foreach ($opcoes_usuarios as $chave => $valor)
					print "<option value='$chave'>$valor</option>";
				?>
			</select>
		</div>
	</div>
	
</div>
<div class="limpar">&nbsp;</div>
<?php print $form->end('Pesquisar'); ?>

<?php if (isset($num_resultados) && $num_resultados > 0) : ?>
	<table class="resultados">
		<thead>
			<tr>
				<th><?php print $paginator->sort('Cód','id'); ?></th>
				<th><?php print $paginator->sort('Cadastrada em','data_hora_cadastrada'); ?></th>
				<th><?php print $paginator->sort('Cliente','cliente_id'); ?></th>
				<th><?php print $paginator->sort('Situação','situacao'); ?></th>
				<th><?php print $paginator->sort('Valor total','valor_total'); ?></th>
				<th colspan="3">Ações</th>
			</tr>
		</thead>
		
		<tbody>
			<?php foreach ($resultados as $r): ?>
				<tr>
					<td><?php print $r['PedidoVenda']['id']; ?></td>
					<td><?php print $html->link($formatacao->dataHora($r['PedidoVenda']['data_hora_cadastrada']),'editar/' . $r['PedidoVenda']['id']) ;?></td>
					<td><?php print $r['PedidoVenda']['cliente_id'].' '.$r['Cliente']['nome']; ?></td>
					<td><?php print $s[$r['PedidoVenda']['situacao']]; ?></td>
					<td><?php print $r['PedidoVenda']['valor_total']; ?></td>
					<td><?php print $html->image('detalhar24x24.png',array('title'=>'Detalhar',
					'alt'=>'Detalhar','url'=>array('action'=>'detalhar',$r['PedidoVenda']['id']))) ?></td>
					<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
					'alt'=>'Editar','url'=>array('action'=>'editar',$r['PedidoVenda']['id']))) ?></td>
					<td>
						<?php print '<a title="Excluir" onclick="javascript: return confirm(\'Deseja realmente excluir este registro?\')"
						href="'.$html->url(array('action'=>'excluir')).'/'.$r['PedidoVenda']['id'].'">'.
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
	
<?php endif; ?>
