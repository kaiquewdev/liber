<?php
class TipoDocumento extends  Model {
	var $name = 'TipoDocumento';
	var $hasMany = array('PagarConta','ReceberConta','FormaPagamento');
	var $validate = array(
		'nome' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		)
	);
	
}

?>