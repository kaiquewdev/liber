<?php

class Motorista extends AppModel {
	var $name = 'Motorista';
	var $actsAs = array('CakePtbr.AjusteData');
	var $belongsTo = array('Veiculo');
	var $validate = array(
		'nome' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'cnh_numero_registro' => array(
			'allowEmpty' => true,
			'rule' => 'numeric',
			'message' => 'Somente números.'
		),
		'cnh_data_validade' => array(
			'allowEmpty' => true,
			'rule' => 'date',
			'message' => 'Data inválida.'
		),
		'sexo' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		)
	);
}

?>