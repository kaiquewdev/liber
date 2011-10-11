<?php
class PedidoVendaItem extends AppModel {
	var $name = 'PedidoVendaItem';
	var $actsAs = array('CakePtbr.AjusteFloat');

	var $belongsTo = array(
		'PedidoVenda' => array(
			'className' => 'PedidoVenda',
			'foreignKey' => 'pedido_venda_id'
		),
		'Produto' => array(
			'className' => 'Produto',
			'foreignKey' => 'produto_id'
		)
	);
	
	var $validate = array (
		'produto_id' => array(
			'allowEmpty' => false,
			'rule' => 'numeric',
			'message' => 'Campo obrigatório. Somente números.'
		),
		'quantidade' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'preco_venda' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		)
	);
}
