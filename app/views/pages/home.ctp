<?php
/**
 * @author        Tobias Sette Ferreira
 * @copyright     Tobias Sette Ferreira - 2011
 * @link          http://gnu.eti.br
 * @package       GFreedom
 * @license       GPL v3
 */

if (Configure::read() == 0):
	$this->cakeError('error404');
endif;

?>

<div class="grupo">
	
	<div class="contas_pagar">
		<h2>Contas a pagar</h2>
		<div style="border: 1px solid">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
			eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
			sunt in culpa qui officia deserunt mollit anim id est laborum.
		</div>
	</div>
	
	<div class="contas_receber" style="width: 34%">
		<h2>Contas a receber</h2>
		<div style="border: 1px solid">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
			eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
			sunt in culpa qui officia deserunt mollit anim id est laborum.
		</div>
	</div>
	
	<div class="pedidos_venda">
		<h2>Pedidos de venda</h2>
		<div style="border: 1px solid">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
			eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
			sunt in culpa qui officia deserunt mollit anim id est laborum.
		</div>
	</div>
	
</div>

<div class="limpar">&nbsp;</div>

<div id="notas_versao">
	<h2>Notas de versão</h2>
	<div style="border: 1px solid">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
			eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
			sunt in culpa qui officia deserunt mollit anim id est laborum.
	</div>
</div>

<script type="text/javascript">
	$(function(){
		
		$('.grupo').sortable ({
			placeholder: "ui-state-highlight"
		});
		
		$('.grupo').disableSelection();
		
	});
</script>

<style type="text/css">
	.contas_pagar, .contas_receber, .pedidos_venda {
		margin: 0;
		padding: 0;
		float: left;
		margin-right: 10px;
		width: 30%;
	}
</style>