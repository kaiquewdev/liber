<?php
class ServicoOrdem extends AppModel {
	var $name = 'ServicoOrdem';
	var $actsAs = array('CakePtbr.AjusteFloat');
	var $belongsTo = array(
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'cliente_id'
		),
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id'
		),
		'FormaPagamento' => array(
			'className' => 'FormaPagamento',
			'foreignKey' => 'forma_pagamento_id',
		),
		'usuario_cadastrou' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_cadastrou'
		),
		'usuario_alterou' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_alterou'
		)
	);
	var $hasMany = array(
		'ServicoOrdemItem' => array(
			'className' => 'ServicoOrdemItem',
			'foreignKey' => 'servico_ordem_id'
			//'dependent' => true
		)
	);
	var $validate = array(
		'cliente_id'  => array(
			'allowEmpty' => false,
			'rule' => 'numeric',
			'message' => 'Campo obrigatório. Somente números.'
		),
		'usuario_id' => array(
			'allowEmpty' => false,
			'rule' => 'numeric',
			'message' => 'Campo obrigatório.'
		),
		'forma_pagamento_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'situacao' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'data_hora_inicio' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		)
	);
	

}
