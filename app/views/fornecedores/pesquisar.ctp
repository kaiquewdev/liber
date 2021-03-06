<script type="text/javascript">
		$(function(){
			//pesquisa cliente
			//autocomplete
			$("#FornecedorNome").autocomplete({
				source: "<?php print $html->url('/',true); ?>/Fornecedores/pesquisaAjaxFornecedor/nome",
				minLength: 3,
				select: function(event, ui) {
					$("#FornecedorId").val(ui.item.id);
					$('#FornecedorNome').val(ui.item.nome);
				}
			});
			// ao digitar o codigo
			$('#FornecedorId').blur(function(){
				codigo = $(this).val();
				if (codigo == null || codigo == '') return null;
				$.getJSON('<?php print $html->url('/',true); ?>/Fornecedores/pesquisaAjaxFornecedor/codigo', {'term': codigo}, function(data) {
					if (data == null) {
						alert ('Fornecedor com o código '+codigo+' não foi encontrado!');
						$('#FornecedorNome').val('');
						$("#FornecedorId")
							.val('')
							.focus();
					}
					else { //encontrou resultados
						data = data[0];
						$("#FornecedorId").val(data.id);
						$('#FornecedorNome').val(data.nome);
					}
				});
			});
		});
</script>
<h2 class="descricao_cabecalho">Pesquisar Fornecedor</h2>

<?php
/**
 * Elimino as divs dos campos input para que nao apareça quais campos
 * sao marcados como obrigatorios no BD, pois aqui isso non ecxiste
 */
print $form->create(null,array('controller'=>'fornecedores','action'=>'pesquisar','autocomplete'=>'off'));
?>
<div class="divs_grupo_2">
	
	<div class="div1_2">
		<div>
			<label style="">Código / nome</label>
			<input style="float:left; width: 10%;" id="FornecedorId" type="text" name="data[Fornecedor][id]" />
			<input style="margin-left: 1%; width: 80%" id="FornecedorNome" type="text" name="data[Fornecedor][nome]" />
		</div>
		<?php
		print '<div>'.$form->input('nome_fantasia', array('label'=>'Nome fantasia','div'=>false)).'</div>';
		print '<div>'.$form->input('bairro',array('div'=>false)).'</div>';
		print '<div>'.$form->input('cidade',array('div'=>false)).'</div>';
		?>
	</div>
	
	<div class="div2_2">
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
					<td><?php print $r['Fornecedor']['id']; ?></td>
					<td><?php print $r['Fornecedor']['tipo_pessoa']; ?></td>
					<td><?php print $html->link($r['Fornecedor']['nome'],'editar/' . $r['Fornecedor']['id']) ;?></td>
					<td><?php print $r['Fornecedor']['nome_fantasia']; ?></td>
					<td><?php print $r['Fornecedor']['cidade']; ?></td>
					<td><?php print $r['Fornecedor']['cpf'].$r['Fornecedor']['cnpj']; ?></td>
					<td><?php print $r['Fornecedor']['rg'].$r['Fornecedor']['inscricao_estadual']; ?></td>
					<td><?php print $r['Usuario']['login']; ?></td>
					<td><?php print $html->image('edit24x24.png',array('title'=>'Editar',
					'alt'=>'Editar','url'=>array('action'=>'editar',$r['Fornecedor']['id']))) ?></td>
					<td><?php print $html->image('detalhar24x24.png',array('title'=>'Detalhar',
					'alt'=>'Detalhar','url'=>array('action'=>'detalhar',$r['Fornecedor']['id']))) ?></td>
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
