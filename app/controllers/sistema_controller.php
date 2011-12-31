<?php

class SistemaController extends AppController {
	var $name = "Sistema";
	var $components = array('Sanitizacao');
	var $uses = array(); //nao ha model para este controller
	#poderia ser utilizado o controller pages
	
	function index() {
		
	}
	
	function ajuda() {
		
	}
	
	function sobre() {
		
	}
	
	function noscript(){
		/**
		 *  basicamente defino um novo layout pois este nao pode ter a tag
		 * noscript que redireciona para a pagina sistema/noscript, pois ficaria em loop infinito.
		 * O novo layout remove scripts e quase todo o menu.
		 */
		$this->layout = 'noscript';
	}
	
	/**
	 * Página inicial (home) da aplicação
	 * Para o funcionamento foi necessario alterar a rota / em app/config/routes.php
	 * outra alternativa: http://www.phpfreaks.com/forums/index.php?topic=240370.0
	 */
	function inicio() {
		$this->loadModel('PagarConta');
		$dadosContasPagar = $this->PagarConta->find('all',array('conditions'=>array('data_vencimento'=>date('Y-m-d')),'limit'=>10,'recursive'=>'1'));
		if (empty($dadosContasPagar)) $contasPagar = 'Não há contas a pagar que vencem hoje.';
		else {
			$contasPagar = '';
			foreach ($dadosContasPagar as $conta) {
				$contasPagar .= "<a href='pagarContas/editar/{$conta['PagarConta']['id']}'>{$conta['Cliente']['nome']} (R\${$conta['PagarConta']['valor']})</a> / ";
			}
		}
		$this->set('contasPagar',$contasPagar);
		
		$this->loadModel('ReceberConta');
		$dadosContasReceber = $this->ReceberConta->find('all',array('conditions'=>array('data_vencimento'=>date('Y-m-d')),'limit'=>10,'recursive'=>'1'));
		if (empty($dadosContasReceber)) $contasReceber = 'Não há contas a receber que vencem hoje.';
		else {
			$contasReceber = '';
			foreach ($dadosContasReceber as $conta) {
				$contasReceber .= "<a href='receberContas/editar/{$conta['ReceberConta']['id']}'>{$conta['Cliente']['nome']} (R\${$conta['ReceberConta']['valor']})</a> / ";
			}
		}
		$this->set('contasReceber',$contasReceber);
		
	}

}

?>