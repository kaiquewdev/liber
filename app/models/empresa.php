<?php

class Empresa extends AppModel {
	var $name = 'Empresa';
	var $hasMany = array('Cliente','Fornecedor');
	var $validate = array(
		'nome' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'site' => array(
			'allowEmpty' => true,
			'rule' => 'url',
			'message' => 'Endereço inválido'
		),
		'endereco_email_principal' => array(
			'allowEmpty' => true,
			'rule' => 'email',
			'message' => 'Endereço inválido'
		),
		'endereco_email_secundario' => array(
			'allowEmpty' => true,
			'rule' => 'email',
			'message' => 'Endereço inválido'
		),
		'logradouro' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'numero' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'bairro' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'cidade' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'estado' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		)
	);
}

?>