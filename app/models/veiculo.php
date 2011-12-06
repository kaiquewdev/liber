<?php

class Veiculo extends AppModel {
	var $name = 'Veiculo';
	var $hosOne = array(
		'Veiculo' => array(
			'className' => 'veiculo',
			'foreignKey' => 'veiculo_padrao'
		),
		'Carregamento' => array (
			'className' => 'carregamento',
			'foreignKey' => 'veiculo_id'
		)
	);
	var $validate = array(
		'modelo' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'placa' => array(
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