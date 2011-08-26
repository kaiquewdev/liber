<?php

class AppController extends Controller {
	/**
	 * Para utilizar autocomplete
	 * http://bakery.cakephp.org/articles/gravyface/2009/07/23/how-to-add-autocomplete-to-eclipse-aptana
	 */
	
	/**
	 * -----------------------
	 * Declaração dos Model's
	 * -----------------------
	 */
	
	/**
	 * Model Cliente
	 * @var Cliente
	 */
	var $Cliente;
	
	/**
	 * --------------------------
	 * Declaração dos Componentes
	 * --------------------------
	 */
	
	/**
	 * AuthComponent
	 * @var $Auth
	 */
	var $Auth;
	
	/**
	 * Componente de Sanitização
	 * @var $Sanitizacao
	 */
	var $Sanitizacao;
	
}


?>