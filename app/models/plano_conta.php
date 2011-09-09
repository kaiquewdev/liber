<?php
class PlanoConta extends  Model {
	var $name = 'PlanoConta';
	var $hasMany = array('PagarConta','ReceberConta');
	var $validate = array(
		'nome' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'tipo' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		)
	);
	
}

?>