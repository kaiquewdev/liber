<?php

class Carregamento extends AppModel {
	var $name = 'Carregamento';
	var $hasMany = array('CarregamentoItem');
	var $belongsTo = array(
		'Motorista' => array(
			'className' => 'motorista',
			'foreignKey' => 'motorista_id'
		),
		'Veiculo' => array(
			'className' => 'veiculo',
			'foreignKey' => 'veiculo_id'
		)
	);
	var $validate = array(
		'descricao' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'motorista_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'veiculo_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		)
	);
}

?>