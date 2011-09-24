<h2 class="descricao_cabecalho">Editar produto</h2>

<?php print $form->create('Produto',array('autocomplete'=>'off','onsubmit'=>'submissaoFormulario(this); return false;')); ?>
	<div style="float: left; position: absolute;">
		<?php
		print $form->label('categoria_produto_id','Categoria',array('class'=>'required'));
		print $form->input('categoria_produto_id', array(
			'div'=>false,
			'label'=>false,
			'options'=>$opcoes_categoria_produto
			));
		?>
	</div>
	<div style="position: absolute; float: left; margin-left: 150px;">
	<?php
		print $form->label('situacao','Situação',array('class'=>'required'));
		print $form->input('situacao',array(
			'div'=>false,
			'label'=>false,
			'options'=>array('E'=>'Em linha','F'=>'Fora de linha')
			));
		?>
	</div>
	<div class="limpar">&nbsp;</div>
	
	<div class="divs_grupo_3">
		<div class="div1_3">
			<?php
			print $form->input('nome',array('label'=>'Nome'));
			print $form->input('tipo_produto',array('label'=>'Tipo'));
			print $form->input('codigo_ean',array('label'=>'Código EAN'));
			print $form->input('codigo_dun',array('label'=>'Código DUN'));
			?>
		</div>
		<div class="div2_3">
			<?php
			print $form->input('preco_custo',array('label'=>'Preço de custo'));
			print $form->input('preco_venda',array('label'=>'Preço de venda'));
			print $form->input('margem_lucro',array('label'=>'Margem de lucro'));
			print $form->input('tem_estoque_ilimitado',array('label'=>'Estoque ilimitado?','options'=>array('N'=>'Não','S'=>'Sim')));
			?>
		</div>
		<div class="div3_3">
			<?php
			print $form->input('estoque_minimo',array('label'=>'Estoque mínimo'));
			print $form->input('unidade',array('label'=>'Unidade'));
			print $form->input('quantidade_estoque_fiscal',array('label'=>'Qtd. estoque fiscal'));
			print $form->input('quantidade_estoque_nao_fiscal',array('label'=>'Qtd. estoque não fiscal'));
			?>
		</div>
	</div>
<?php print $form->end('Gravar'); ?>
