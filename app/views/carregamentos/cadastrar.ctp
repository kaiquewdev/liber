<script type="text/javascript">
	$(function(){
		$('#selecionar_checkbox').click(function(){
			if ( $(this).is(':checked') ) {
				$('form :checkbox').each(function(){
					$(this).attr('checked','checked');
				});
			}
			else {
				$('form :checkbox').each(function(){
					$(this).removeAttr('checked');
				});
			}
		});
		
		$('input[type=submit]').click(function(){
			if ($('#CarregamentoDescricao').val() == '') {
				alert ('O campo descrição é obrigatório!');
				return false;
			}
			
			cont = 0;
			$('form :checkbox').each(function(){
				if ( $(this).is(':checked') ) cont++;
			});
			if (cont == 0) {
				alert ('Marque ao menos um pedido!');
				return false;
			}
		});
	});
</script>

<h2 class="descricao_cabecalho">Cadastrar carregamento</h2>


<?php
// #XXX implementar o escolha automatica do veiculo assim que escolhe o motorista
// com base no veiculo definido como padrao no cadastro do motorista
print $form->create('Carregamento',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;'));
print $form->input('descricao',array('label'=>'Descrição'));
?>
<div class="grupo_horizontal">
	<?php
		print $form->label('motorista_id','Motorista',array('class'=>'required'));
		print $form->input('motorista_id',array(
			'div'=>false,
			'label'=>false,
			'options'=>$opcoes_motoristas
			));
		?>
</div>
<div class="grupo_horizontal">
	<?php
		print $form->label('veiculo_id','Veículo',array('class'=>'required'));
		print $form->input('veiculo_id',array(
			'div'=>false,
			'label'=>false,
			'options'=>$opcoes_veiculos
			));
		?>
</div>
<div class="limpar"></div>

	<fieldset>
		<legend>Pedidos</legend>
		<table>
			<thead>
				<th> <input type="checkbox" name="selecionar_checkbox" id="selecionar_checkbox" /> Selecionar</th>
				<th>Pedido</th>
				<th>Cliente</th>
				<th>Valor bruto</th>
				<th>Valor líquido</th>
			</thead>
			
			<tbody>
				<?php
				$cont = 0;
				foreach ($consulta_pedidos as $c):
					$id_pedido = $c['PedidoVenda']['id'];
					$id = "CarregamentoItemPedidoVendaId${id_pedido}";
					$nome = "data[CarregamentoItem][${cont}][pedido_venda_id]";
					$valor = $id_pedido;
				?>
					<tr>
						<td> <input type="checkbox" name="<?php print $nome;?>" id="<?php print $id;?>" value="<?php print $valor; ?>" /> </td>
						<td><?php print $c['PedidoVenda']['id']?></td>
						<td><?php print $c['Cliente']['nome']?></td>
						<td><?php print $c['PedidoVenda']['valor_bruto']?></td>
						<td><?php print $c['PedidoVenda']['valor_liquido']?></td>
					</tr>
				<?php
					$cont++;
				endforeach;
				?>
			</tbody>
			
		</table>
	</fieldset>
<?php
print $form->input('observacao',array('label'=>'Observação'));
print $form->end('Gravar');
?>

