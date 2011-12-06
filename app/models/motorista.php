<?php

class Motorista extends AppModel {
	var $name = 'Motorista';
	var $hasOne = array('Carregamento');
	var $belongsTo = array(
		'Veiculo' => array(
			'className' => 'veiculo',
			'foreignKey' => 'veiculo_padrao'
		)
	);
	var $actsAs = array('CakePtbr.AjusteData');
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
		)
	);
}

?>