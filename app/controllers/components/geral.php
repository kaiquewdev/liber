<?php

/**
 * Provê métodos para diversos fins
 */
class GeralComponent {
	
	/**
	 * Recebe um numero em formato brasileiro e retorna-o em formato americano
	 * @return number
	 */
	function moeda2numero ($variavel) {
		$variavel = preg_replace('/\./', '', $variavel);
		$variavel = preg_replace('/,/', '.', $variavel);
		return number_format($variavel,2,'.','');
	}
	
	/**
	 * Recebe um numero em formato americano e formata para formato brasileiro
	 * @return number/string
	 */
	function numero2moeda ($variavel) {
		return number_format($variavel,2,',','.');
	}
	
	/**
	 * $data para o formato ano-mes-dia
	 * 
	 * Baseado na função do Juan Bastos
	 */
	function ajustarData($data) {
		if (isset($data) && preg_match('/\d{1,2}\/\d{1,2}\/\d{2,4}/', $data)) {
			list($dia, $mes, $ano) = explode('/', $data);
			if (strlen($ano) == 2) {
				if ($ano > 50) {
					$ano += 1900;
				} else {
					$ano += 2000;
				}
			}
			$retorno = "$ano-$mes-$dia";
			return $retorno;
		}
		else return false;
	}


}

?>