<?php

if (Configure::read() == 0):
	$this->cakeError('error404');
endif;

?>

<div class="conteudo">

	<div style="width: 639px; margin-top: 10px; margin-left: auto; margin-right: auto;">
		<?php print $html->image('logotipo_grande.png',array('alt'=>'Liber')); ?>
	</div>
	
	<div class="limpar">&nbsp;</div>
	
	<div class="sortable_coluna">
		<div class="sortable_caixa">
			<div class="sortable_cabecalho">Contas a pagar</div>
			<div class="sortable_conteudo">
				<?php if (!empty($contasPagar)) print $contasPagar ?>
			</div>
		</div>
	</div>
	
	<div class="sortable_coluna">
		<div class="sortable_caixa">
			<div class="sortable_cabecalho">Contas a receber</div>
			<div class="sortable_conteudo">
				<?php if (!empty($contasReceber)) print $contasReceber ?>
			</div>
		</div>
	</div>	
	
	<div class="sortable_coluna">
		<div class="sortable_caixa">
			<div class="sortable_cabecalho">Notas de versão</div>
			<div class="sortable_conteudo">
				30/12/11 Rotina de carregamento terminada.
			</div>
		</div>
	</div>
	<!--
	<div class="sortable_coluna">
		<div class="sortable_caixa">
			<div class="sortable_cabecalho">&nbsp;</div>
			<div class="sortable_conteudo">
				&nbsp;
			</div>
		</div>
	</div> -->
	
	<div class="limpar">&nbsp;</div>
</div>

<script type="text/javascript">
	$(function(){
		
		$('.sortable_coluna').sortable ({
			connectWith: ".sortable_coluna"
		});
		
		$('.sortable_caixa').addClass('ui-widget ui-widget-content ui-helper-clearfix ui-corner-all')
			.find('.sortable_cabecalho')
				.addClass('ui-widget-header ui-corner-all')
				.prepend("<span class='ui-icon ui-icon-minusthick'></span>")
				.end()
			.find('.sortable_conteudo');

		$('.sortable_cabecalho .ui-icon').click(function() {
			$(this).toggleClass('ui-icon-minusthick').toggleClass('ui-icon-plusthick');
			$(this).parents('.sortable_caixa:first').find('.sortable_conteudo').toggle();
		});

		$('.sortable_coluna').disableSelection();
		
	});
</script>

<style type="text/css">
	
	.sortable_caixa { margin: 0 1em 1em 0; }
	.sortable_cabecalho { margin: 0.3em; padding-bottom: 4px; padding-left: 0.2em; }
	.sortable_cabecalho .ui-icon { float: right; }
	.sortable_conteudo { padding: 0.4em; }
	.ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
	.ui-sortable-placeholder * { visibility: hidden; }
	
	.conteudo {
		
	}
	
	.sortable_coluna {
		margin: 0;
		padding: 0;
		float: left;
		margin-right: 10px;
		width: 30%;
	}
	
</style>