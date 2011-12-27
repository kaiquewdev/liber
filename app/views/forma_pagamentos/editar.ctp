<script type="text/javascript">
	// variaveis a serem utilizadas no arquivo forma_pagamento.js
	var raiz_site = "<?php print $this->Html->url('/',true); ?>/";
</script>

<?php $javascript->link('forma_pagamento.js',false); ?>

<h2 class="descricao_cabecalho">Editar forma de pagamento</h2>

<?php print $form->create('FormaPagamento',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;')); ?>

<div class="grupo_horizontal">
	<?php print $form->input('nome',array('label'=>'Nome')); ?>
</div>
<div class="grupo_horizontal">
	<?php print $form->input('tipo_documento_id',array('label'=>'Documento','options'=>$opcoes_documentos)); ?>
</div>
<div class="grupo_horizontal">
	<?php print $form->input('conta_principal',array('label'=>'Conta principal','options'=>$opcoes_contas)); ?>
</div>

<div class="limpar">&nbsp;</div>

<div class="divs_grupo_2">
	
	<div class="div1_2">
		
		<fieldset>
			<legend>Parcelas</legend>
				<table>
					<thead>
						<tr>
							<th>Ordem</th>
							<th>Número de dias</th>
							<th>Ações</th>
						</tr>
					</thead>
					
					<tbody id="parcelas_inseridas">
						<?php //aqui ficam os itens incluidos
							if (isset($campos_ja_inseridos)) {
								$i = 0;
								$valor_total = 0;
								foreach ($campos_ja_inseridos as $item) {
									print '<tr>'.
									'<td> <input name="none" value="'.($i+1).'" class="noinput"/> '.
									'<td> <input type="text" name="data[FormaPagamentoItem]['.$i.'][dias_intervalo_parcela]" value="'.$item['dias_intervalo_parcela'].'" class="noinput item_id" /> </td>'.
									'<td> <img src="'.$this->Html->url('/',true).'/img/del24x24.png" class="remover_linha"/> </td>'.
									'</tr>'."\n";
									$i++;
								}
							}
							?>
					</tbody>
					<input type="hidden" id="numero_itens_incluidos" value="<?php if (isset($i)) print $i; else print '0';?>" />
				</table>
		</fieldset>
		
	</div>	

	<div class="div2_2">
		
		<fieldset>
			<legend>Inserir parcelas</legend>
			<div id="form_inserir_parcelas">
				<div id="parcelas_inserir">
					<label for="[PesquisaFormaPagamentoItem][dias_intervalo_parcela]">Número de dias da parcela</label>
					<input type="text" name="[PesquisaFormaPagamentoItem][dias_intervalo_parcela]" id="PesquisaFormaPagamentoItemDiasIntervaloParcela" value="" class="required number" />
				</div>
				<p>
					<input type="button" value="Adicionar" class="botao_aviso"
						style="float: left; width: 40%;" onclick="adicionar_parcela(); return false;" />
					<input type="button" value="Limpar" class="botao_erro" style="width: 40%; margin-left: 10%;"
						onclick="limpar_pesquisa(); return false;" />
				</p>
			</div>
		</fieldset>
		
	</div>
		
</div>
<?php print $form->end('Gravar'); ?>
