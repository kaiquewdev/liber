<?php
class PedidoVendaItem extends AppModel {
	var $name = 'PedidoVendaItem';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'PedidoVenda' => array(
			'className' => 'PedidoVenda',
			'foreignKey' => 'pedido_venda_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Produto' => array(
			'className' => 'Produto',
			'foreignKey' => 'produto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
