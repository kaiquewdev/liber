<?php

/**
 * Provê métodos para sanitização
 */

class SanitizacaoComponent {
	
	/**
	 * Retorna $var sem acentos e Ç e com
	 * caracteres maiusculos.
	 */
	function substitui_caracteres_especiais ($var) {
		$acentos = array(
		'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
    	'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
    	'C' => '/&Ccedil;/',
    	'c' => '/&ccedil;/',
    	'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
    	'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
    	'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
    	'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
    	'N' => '/&Ntilde;/',
    	'n' => '/&ntilde;/',
    	'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
    	'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
    	'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
    	'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
    	'Y' => '/&Yacute;/',
		'y' => '/&yacute;|&yuml;/',
		'a.' => '/&ordf;/',
		'o.' => '/&ordm;/');
		
		/**
		 * $var cairá nesse if caso a função tenha sido chamada
		 * com apenas um argumento
		 * ou quando esta função for chamada recursivamente
		 */
		if ( ! is_array($var) ) {
	    	$var = preg_replace($acentos, array_keys($acentos),	htmlentities($var,ENT_NOQUOTES, 'UTF-8'));
	    	$var = strtoupper($var);
	    	return ($var);
		}
		else {
			return array_map(array('SanitizacaoComponent','substitui_caracteres_especiais'),$var);
		}
	}

	/**
	 * Retorna em maiusculo a primeira letra de cada palavra contida em $var
	 */
	function primeira_letra_maiuscula ($var) {
		/**
		 * $var cairá nesse if caso a função tenha sido chamada
		 * com apenas um argumento
		 * ou quando esta função for chamada recursivamente
		 */
		if ( ! is_array($var) ) {
	    	$var = ucwords($var);
	    	return ($var);
		}
		else {
			return array_map(array('SanitizacaoComponent','primeira_letra_maiuscula'),$var);
		}
	}
	
	function string_maiuscula ($var) {
		/**
		 * $var cairá nesse if caso a função tenha sido chamada
		 * com apenas um argumento
		 * ou quando esta função for chamada recursivamente
		 */
		if ( ! is_array($var) ) {
	    	$var = mb_strtoupper($var,'UTF-8');
	    	return ($var);
		}
		else {
			return array_map(array('SanitizacaoComponent','string_maiuscula'),$var);
		}
	}
	
	/**
	 * Alias para uma funcao de sanitização que será utilizada
	 */
	function sanitizar ($var) {
		return $this->string_maiuscula($var);
	}
	
}

?>