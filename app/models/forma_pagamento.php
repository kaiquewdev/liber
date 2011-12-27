<?php

class FormaPagamento extends AppModel {
	var $name='FormaPagamento';
	var $belongsTo = array(
		'Conta' => array(
			'className' => 'Conta',
			'foreignKey' => 'conta_principal'
		),
		'TipoDocumento' => array(
		    'className' => 'TipoDocumento',
		    'foreignKey' => 'tipo_documento_id'
		),
	);
	var $hasMany = array(
		'FormaPagamentoItem' => array(
			'class_name' => 'FormaPagamentoItem',
		),
		'ServicoOrdem' => array(
			'className' => 'ServicoOrdem'
		),
		'PedidoVenda' => array(
			'className' => 'PedidoVenda'
		)
	);
	var $validate = array(
		'nome' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'conta_principal' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'tipo_documento_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
	);
}

?>