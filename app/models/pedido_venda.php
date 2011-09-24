<?php
class PedidoVenda extends AppModel {
	var $name = 'PedidoVenda';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'cliente_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'FormaPagamento' => array(
			'className' => 'FormaPagamento',
			'foreignKey' => 'forma_pagamento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Usuario_alterou' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_alterou',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'PedidoVendaItem' => array(
			'className' => 'PedidoVendaItem',
			'foreignKey' => 'pedido_venda_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
