<h2 class="descricao_cabecalho">Detalhando pedido de venda número <?php print $c['PedidoVenda']['id']; ?></h2>

<fieldset>
	<legend>Dados do pedido</legend>
	
	<div class="grupo_horizontal">
		<label>Data e hora do registro </label> <input class="noinput" value="<?php print $formatacao->dataHora($c['PedidoVenda']['data_hora_cadastrado']);?>" />
	</div>
	<div class="grupo_horizontal"> 
		<label>Cliente </label> <input class="noinput" value="<?php print $c['PedidoVenda']['cliente_id'].' '.$c['Cliente']['nome'];?>" />
	</div>
	<div class="grupo_horizontal">
		<label>Forma de pagamento </label> <input class="noinput" value="<?php print $c['PedidoVenda']['forma_pagamento_id'].' '.$c['FormaPagamento']['nome'] ;?>" />
	</div>
	<div class="grupo_horizontal">
		<label>Situação </label> <input class="noinput" value="<?php print $opcoes_situacoes[$c['PedidoVenda']['situacao']] ;?>" />
	</div>
</fieldset>


<fieldset>
	<legend>Produtos incluídos</legend>

	<table>
		<thead>
			<tr>
				<th>Cód.</th>
				<th>Nome</th>
				<th>Quantidade</th>
				<th>Preço de venda</th>
			</tr>
		</thead>
		
		<tbody>
			<?php
			foreach ($c['PedidoVendaItem'] as $r):?>
			<tr>
				<td><?php print $r['produto_id'] ?></td>
				<td><?php print $r['produto_nome'] ?></td>
				<td><?php print $r['quantidade'] ?></td>
				<td><?php print $r['preco_venda'] ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
		
	</table>
	<div class="grupo_horizontal">
		<label><b>Valor bruto</b></label> <input class="noinput" value="R$<?php print $c['PedidoVenda']['valor_bruto'] ;?>" />
	</div>
	<div class="grupo_horizontal">
		<label><b>Valor líquido</b></label> <input class="noinput" value="R$<?php print $c['PedidoVenda']['valor_liquido'] ;?>" />
	<div>
</fieldset>