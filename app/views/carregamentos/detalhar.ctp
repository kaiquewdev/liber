<?php if (! isset($carregamento) || ! $carregamento) die; ?>

<h2 class="descricao_cabecalho">Detalhar carregamento</h2>

Criado em: <h1><?php print $formatacao->dataHora($carregamento['Carregamento']['data_hora_criado']); ?></h1>
Descricao: <h1><?php print $carregamento['Carregamento']['descricao'] ?></h1>
Motorista: <h1><?php print $carregamento['Motorista']['nome'] ?></h1>
Veículo: <h1><?php print $carregamento['Veiculo']['placa'] ?></h1>

<h3>Pedidos de venda incluídos neste carregamento:</h3>
<table>
	<thead>
		<tr>
			<th>Número pedido de venda</th>
		</tr>
	</thead>
	
	<tbody>
		<? foreach ($carregamento['CarregamentoItem'] as $item) : ?> 
			<tr>
				<td><?php print $html->link($item['pedido_venda_id'],'/pedidoVendas/detalhar/'.$item['pedido_venda_id']) ;?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
	
</table>

Observação: <textarea rows="5" readonly="readonly"><?php  print $carregamento['Carregamento']['observacao'];?></textarea>
