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
		 *  basicamente definido um novo layout pois este nao pode ter a tag
		 * noscript que redireciona para a pagina sistema/noscript, pois ficaria em loop infinito.
		 * O novo layout remove scripts e quase todo o menu.
		 */
		$this->layout = 'noscript';
	}
}

?>