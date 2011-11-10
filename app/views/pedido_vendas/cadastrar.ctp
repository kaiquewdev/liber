<script type="text/javascript">
	// variaveis a serem utilizadas no arquivo pedido_venda.js
	var raiz_site = "<?php print $this->Html->url('/',true); ?>/";
	var ajaxPesqCliente = "<?php print $this->Html->url(array('controller'=>'Clientes','action'=>'pesquisaAjaxCliente')); ?>/";
	var ajaxPesqProduto = "<?php print $this->Html->url(array('controller'=>'Produtos','action'=>'pesquisaAjaxProduto')); ?>/";
</script>

<?php
$javascript->link('pedido_venda.js',false);
$javascript->link('formatar_moeda.js',false);
?>

<h2 class="descricao_cabecalho">Cadastrar pedido de venda</h2>

<?php print $form->create('PedidoVenda',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;')); ?>

<div id="pedido_venda_abas">
	<ul>
		<li><a href="#informacoes">Informações</a></li>
		<li><a href="#produtos">Produtos</a></li>
		<li><a href="#outros">Outros</a></li>
	</ul>
	
	<div id="informacoes">
		<div class="divs_grupo_2">
			<div class="div1_2">
				<div>
					<?php
					print $form->label('cliente_id','Cliente',array('class'=>'required'));
					print $form->input('cliente_id', array(
						'div'=>false,
						'label'=>false,
						'type'=>'text',
						'style' => 'float:left; width: 10%;'
						));
					?>
					<input style="margin-left: 1%; width: 80%" type="text" name="pesquisar_cliente" id="pesquisar_cliente" />
				</div>
				<?php
				print $form->input('forma_pagamento_id',array('label'=>'Forma de pagamento','options'=>$opcoes_forma_pamamento));
				print $form->input('data_venda',array('label'=>'Data da venda','type'=>'text','class'=>'mascara_data datepicker'));
				print $form->input('data_saida',array('label'=>'Data da saída','type'=>'text','class'=>'mascara_data datepicker'));
				?>
			</div>
			<div class="div2_2">
				<?php
				print $form->input('data_entrega',array('label'=>'Data entrega','type'=>'text','class'=>'mascara_data datepicker'));
				print $form->input('situacao',array('label'=>'Situação','options'=>array(
				'A' => 'Aberto',
				'O' => 'Orçamento',
				/*'C' => 'Cancelado',
				'V' => 'Vendido'*/
				)));
				print $form->input('desconto',array('label'=>'Desconto'));
				?>
			</div>
		</div>
		<div class="limpar">&nbsp;</div>
	</div> <!-- fim de informacoes -->
	
	<div id="produtos">
		<div>
			<fieldset>
				<legend>Pesquisar produto</legend>
				<div id="form_pesquisar_produtos">
					<div id="produtos_pesquisar">
						<label for="[Produto][id]" style="float: left;">Código</label>
						<label for="[Produto][nome]" style="float: left; margin-left: 2%;">Produto</label>
						<label for="[Produto][quantidade]" style="float: left; margin-left: 50%;">Disponível</label>
						<label for="[Produto][quantidade]" style="float: left; margin-left: 1%;">Qtd.</label>
						<label for="[Produto][preco_venda]" style="float:left; margin-left: 3%;">Valor</label>
						<div style="clear: both;"></div>
						<input type="text" name="[Produto][id]" id="ProdutoId" value="" class="required number" style="float: left;width: 5%;" />
						<input type="text" name="[Produto][nome]" id="ProdutoNome" value="" style="margin-left:1%; width: 53%;" />
						<input type="text" name="[Produto][quantidade_estoque]" id="ProdutoQuantidadeEstoque" value="" class="required number" style="margin-left:1%; width: 5%;" readonly="readonly" />
						<input type="text" name="[Produto][quantidade]" id="ProdutoQuantidade" value="" class="required number" style="margin-left:1%; width: 5%;" />
						<input type="text" name="[Produto][preco_venda]" id="ProdutoPrecoVenda" value="" style="margin-left:1%; width: 5%;" />
						
						<input type="hidden" name="[Produto][categoria]" id="ProdutoCategoria" value="" />
						<div style="clear: both;"></div>
					</div>
					<input type="button" value="Adicionar" class="botao_aviso"
					style="float: left; width: 10%;" onclick="adicionar_produto(); return false;" />
				</div>
			</fieldset>
		</div>
			
		<div>
			<fieldset id="fieldset_produtos_incluidos">
				<legend>Produtos incluídos</legend>
				<!-- 
					#TODO adicionar ajustes das colunas da tabela conforme o tamanho do campo input
					style="border-collapse:collapse;"
					-->
				<table style="font-size: 80%;">
					<thead>
						<tr>
							<th style="width: 5%;">Cód.</th> <th>Nome</th> <th style="width: 5%;">Qtd.</th> <th style="width: 5%;">Valor</th>  <th style="width: 5%;">Ações</th>
						</tr>
					</thead>
					<tbody id="produtos_incluidos">
						<?php //aqui ficam os itens incluidos
						if (isset($campos_ja_inseridos)) {
							$i = 0;
							$valor_total = 0;
							foreach ($campos_ja_inseridos as $item) {
								print '<tr>'.
								'<td> <input type="text" name="data[PedidoVendaItem]['.$i.'][produto_id]" value="'.$item['produto_id'].'" class="noinput item_id" /> </td>'.
								'<td> <input type="text" name="data[PedidoVendaItem]['.$i.'][produto_nome]" value="'.$item['produto_nome'].'" class="noinput item_nome" /> </td>'.
								'<td> <input type="text" name="data[PedidoVendaItem]['.$i.'][quantidade]" value="'.$item['quantidade'].'" class="noinput item_qtd" /> </td>'.
								'<td> <input type="text" name="data[PedidoVendaItem]['.$i.'][preco_venda]" value="'.$item['preco_venda'].'" class="noinput item_val" /> </td>'.
								'<td> <img src="'.$this->Html->url('/',true).'/img/del24x24.png" class="remover_linha"/> </td>'.
								'</tr>'."\n";
								$i++;
								$valor_total += $item['quantidade'] * $geral->moeda2numero($item['preco_venda']);
							}
							$valor_total = $geral->numero2moeda($valor_total);
						}
						?>
					</tbody>
					<input type="hidden" id="numero_itens_incluidos" value="<?php if (isset($i)) print $i; else print '0';?>" />
					<input type="hidden" id="preco_custo" value="0" />
				</table>
				<b>Valor total: </b> R$ <span id="valor_total"><?php if (isset($valor_total)) print $valor_total; else print '0'; ?></span>
			</fieldset>
		</div>
			
		<div class="limpar">&nbsp;</div>
	</div> <!-- fim de produtos -->
	
	<id id="outros">
		<div class="grupo_horizontal">
			<?php print $form->input('custo_frete',array('label'=>'Custo do frete')); ?>
		</div>
		<div class="grupo_horizontal">
			<?php print $form->input('custo_seguro',array('label'=>'Custo do seguro')); ?>
		</div>
		<div class="grupo_horizontal">
			<?php print $form->input('custo_outros',array('label'=>'Outros custos')); ?>
		</div>
		<div class="limpar"></div>
		<?php print $form->input('observacao',array('label'=>'Observação')); ?>
	
	</id> <!-- fim de outros -->
	
</div>
<br/>

<?php print $form->end('Gravar'); ?>
