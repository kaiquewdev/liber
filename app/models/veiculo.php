<?php

class Veiculo extends AppModel {
	var $name = 'Veiculo';
	var $hosOne = array('Motorista');
	var $validate = array(
		'modelo' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'tipo' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'ano' => array(
			'allowEmpty' => true,
			'rule' => 'numeric',
			'message' => 'Somente números.'
		)
	);
}

?>