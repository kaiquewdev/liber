<?php
class PedidoVenda extends AppModel {
	var $name = 'PedidoVenda';
	var $actsAs = array('CakePtbr.AjusteFloat','CakePtbr.AjusteData');

	var $belongsTo = array(
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'cliente_id'
		),
		'FormaPagamento' => array(
			'className' => 'FormaPagamento',
			'foreignKey' => 'forma_pagamento_id'
		),
		'UsuarioCadastrou' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_cadastrou'
		),
		'UsuarioAlterou' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_alterou'
		),
		'Empresa' => array(
			'className' => 'Empresa',
		)
	);
	
	var $hasMany = array(
		'PedidoVendaItem' => array(
			'className' => 'PedidoVendaItem',
			'foreignKey' => 'pedido_venda_id'
		),
		'CarregamentoItem' => array(
			'className' => 'CarregamentoItem',
			'foreignKey' => 'pedido_venda_id'
		)
	);
	
	var $validate = array(
		'cliente_id'  => array(
			'allowEmpty' => false,
			'rule' => 'numeric',
			'message' => 'Campo obrigatório. Somente números.'
		),
		'forma_pagamento_id' => array(
			'allowEmpty' => false,
			'rule' => 'numeric',
			'message' => 'Campo obrigatório.'
		),
		'situacao' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'data_saida' => array(
			'allowEmpty' => true,
			'rule' => 'date',
			'message' => 'Data inválida.'
		),
		'data_entrega' => array(
			'allowEmpty' => true,
			'rule' => 'date',
			'message' => 'Data inválida.'
		),
		'data_venda' => array(
			'allowEmpty' => false,
			'rule' => 'date',
			'message' => 'Data obrigatória.'
		),
		'empresa_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
	);
}
