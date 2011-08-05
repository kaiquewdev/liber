<?php

/**
 * Provê métodos para sanitização
 */

class SanitizacaoComponent {
	
	/**
	 * Retorna $var sem acentos e Ç e com
	 * caracteres maiusculos.
	 */
	function sanitizar ($var) {
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
			return array_map(array('SanitizacaoComponent','sanitizar'),$var);
		}
	}
	
}

?>