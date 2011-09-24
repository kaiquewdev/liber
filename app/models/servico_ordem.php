<?php
class ServicoOrdem extends AppModel {
	var $name = 'ServicoOrdem';
	var $actsAs = array('AjusteFloat');

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

}
