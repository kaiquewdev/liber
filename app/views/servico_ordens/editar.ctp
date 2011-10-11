<?php
$javascript->link('servico_ordem-editar.js',false);
$javascript->link('formatar_moeda.js',false);
?>

<h2 class="descricao_cabecalho">Editar ordem de serviço</h2>

<?php print $form->create('ServicoOrdem',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;')); ?>

<div id="servico_ordem_abas">
	<ul>
		<li><a href="#informacoes">Informações</a></li>
		<li><a href="#servicos">Serviços</a></li>
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
				print $form->input('dias_garantia',array('label'=>'Dias de garantia'));
				?>
			</div>
			<div class="div2_2">
				<?php
				print $form->input('data_hora_inicio',array('label'=>'Data e hora do início'));
				print $form->input('situacao',array('label'=>'Situação','options'=>array(
				'O' => 'Orçamento',
				'E' => 'Em espera',
				'X' => 'Em execução',
				'F' => 'Finalizada',
				'E' => 'Entregue',
				'C' => 'Cancelada'
				)));
				print $form->input('usuario_id',array('label'=>'Técnico','options'=>$opcoes_tecnico));
				?>
			</div>
		</div>
		<div class="limpar">&nbsp;</div>
	</div> <!-- fim de informacoes -->
	
	<div id="servicos">
		<div class="divs_grupo_2">
			
			<div class="div1_2">
				<fieldset id="fieldset_servicos_incluidos">
					<legend>Serviços incluídos</legend>
					<!-- 
						#TODO adicionar ajustes das colunas da tabela conforme o tamanho do campo input
						style="border-collapse:collapse;"
						-->
					<table>
						<thead>
							<tr>
								<th style="width: 10%;">Cód.</th> <th>Nome</th> <th style="width: 15%;">Qtd.</th> <th style="width: 15%;">Valor</th>  <th>Ações</th>
							</tr>
						</thead>
						<tbody id="servicos_incluidos">
							<?php //aqui ficam os itens incluidos
							$i = 0;
							$valor_total = 0;
							foreach ($campos_ja_inseridos as $item) {
								print '<tr>'.
								'<td> <input type="text" name="data[ServicoOrdemItem]['.$i.'][servico_id]" value="'.$item['servico_id'].'" class="noinput item_id" /> </td>'.
								'<td> <input type="text" name="data[ServicoOrdemItem]['.$i.'][servico_nome]" value="'.$item['servico_nome'].'" class="noinput item_nome" /> </td>'.
								'<td> <input type="text" name="data[ServicoOrdemItem]['.$i.'][quantidade]" value="'.$item['quantidade'].'" class="noinput item_qtd" /> </td>'.
								'<td> <input type="text" name="data[ServicoOrdemItem]['.$i.'][valor]" value="'.$formatacao->numero2moeda($item['valor']).'" class="noinput item_val" /> </td>'.
								'<td> <img src="'.$this->Html->url('/',true).'/img/del24x24.png" class="remover_linha"/> </td>'.
								'</tr>'."\n";
								$i++;
								//valor é retornado direto do banco, em formato americano, por isso nao converto
								$valor_total += $item['quantidade'] * $item['valor'];
							}
							$valor_total = $formatacao->numero2moeda($valor_total);
							?>
						</tbody>
						<input type="hidden" id="numero_itens_incluidos" value="<?php if (isset($i)) print $i; else print '0';?>" />
					</table>
					<b>Valor total: </b> R$ <span id="valor_total"><?php if (isset($valor_total)) print $valor_total; else print '0'; ?></span>
				</fieldset>
			</div>
			
			<div class="div2_2">
				<fieldset>
					<legend>Pesquisar serviço</legend>
					<div id="form_pesquisar_servicos">
						<div id="servicos_pesquisar">
							<label for="[Servico][id]">Código</label>
							<input type="text" name="[Servico][id]" id="ServicoId" value="" class="required number" />
							
							<label for="[Servico][nome]">Serviço</label>
							<input type="text" name="[Servico][nome]" id="ServicoNome" value="" />
							
							<input type="hidden" name="[Servico][categoria]" id="ServicoCategoria" value="" />
							
							<label for="[Servico][quantidade]">Quantidade</label>
							<input type="text" name="[Servico][quantidade]" id="ServicoQuantidade" value="" class="required number" />
							
							<label for="[Servico][valor]">Valor</label>
							<input type="text" name="[Servico][valor]" id="ServicoValor" value="" />
						</div>
						<p>
							<input type="button" value="Adicionar" class="botao_aviso"
								style="float: left; width: 40%;" onclick="adicionar_servico(); return false;" />
							<input type="button" value="Limpar" class="botao_erro" style="width: 40%; margin-left: 10%;"
								onclick="limpar_pesquisa(); return false;" />
						</p>
					</div>
				</fieldset>
			</div>
			
		</div>
		<div class="limpar">&nbsp;</div>
	</div> <!-- fim de servicos -->
	
	<id id="outros">
		<?php
		print $form->input('defeitos_relatados',array('label'=>'Defeitos relatados','rows'=>'3'));
		print $form->input('laudo_tecnico',array('label'=>'Laudo técnico','rows'=>'3'));
		print $form->input('observacao',array('label'=>'Observação','rows'=>'3'));
		?>
	<div class="limpar">&nbsp;</div>
	</id> <!-- fim de outros -->
	
</div>
<br/>

<?php print $form->end('Gravar'); ?>
