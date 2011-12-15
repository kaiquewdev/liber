<?php

class ReceberConta extends AppModel {
	var $name = 'ReceberConta';
	var $actsAs = array('CakePtbr.AjusteFloat','CakePtbr.AjusteData' => 'data_vencimento');
	var $belongsTo = array(
		'PlanoConta' => array(
			'className' => 'PlanoConta'
		),
		'Conta' => array(
			'className' => 'Conta',
			'foreignKey' => 'conta_origem'
		),
		'TipoDocumento' => array(
			'className' => 'TipoDocumento'
		),
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'cliente_fornecedor_id'
		),
		'Fornecedor' => array(
			'className' => 'Fornecedor',
			'foreignKey' => 'cliente_fornecedor_id'
		),
		'Empresa' => array(
			'className' => 'Empresa'
		)
	);
	var $validate = array(
		'eh_fiscal' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'eh_cliente_ou_fornecedor' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'cliente_fornecedor_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'tipo_documento_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'valor' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'conta_origem' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'plano_conta_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'data_vencimento' => array(
			'obrigatorio' => array (
				'rule' => 'notEmpty',
				'message' => 'Campo obrigatório.'
			),
			'data' => array (
				'rule' => 'date',
				'message' => 'Data inválida.'
			)
		),
		'empresa_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'situacao' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		)
	);
}

?>