<?php

class GeralHelper extends AppHelper {
	
	function moeda2numero ($moeda) {
		// toda 'moeda' tem uma virgula. Eu espero
		if (! preg_match_all('/,/', $moeda,$retorno)) return $moeda;
		$moeda = preg_replace('/\./', '', $moeda);
		$moeda = preg_replace('/,/', '.', $moeda); 
		return number_format($moeda,2,'.','');
	}
	
	function numero2moeda ($numero) {
		// este metodo deve receber apenas numeros
		if (! is_numeric($numero)) return $numero;
		return number_format($numero,2,',','.');
	}

}
