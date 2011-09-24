<?php

/**
 * Classe contendo metodos uteis e frequentemente utilizados
 */
class UteisHelper extends AppHelper {
	var $helpers = array('Form');
	
	/**
	 * Insere um botao de submit juntamente com um script
	 * em Jquery-UI para exibir a confirmação de
	 * submissao do formulario
	 */
	function finalFormulario($nome_formulario, $nome_botao = 'Gravar') {
		$retorno = null;
		$retorno .= $this->Form->end($nome_botao);
		//se nao informar nome do formulario, retorna apenas o botao
		if (empty ($nome_formulario)) return $retorno;
		$retorno .= '
			<script type="text/javascript">
			$(function() {
			var $dialogo = $(\'<div title="Dialogo"><p>Deseja enviar os dados?</p></div>\');
			$dialogo.dialog({
					resizable: true,
					//height:300,
					//width: 300,
					autoOpen: false,
					modal: true,
					buttons: {
						\'Sim\': function() {
							$( this ).dialog( "close" );
							document.forms["'.$nome_formulario.'"].submit();
						},
						\'Não\': function() {
							$( this ).dialog( "close" );
						}
					}
				});
			$(\'form#'.$nome_formulario.'\').submit(function(e){
			    e.preventDefault();
			    $dialogo.dialog(\'open\');
			});
		});
		</script>';
	return $retorno;
	}
	
	
	
}

?>