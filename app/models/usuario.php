<?php

class Usuario extends AppModel {
	var $name = "usuario";
	var $hasMany = array(
		'Cliente_usuario_cadastrou' => array(
			'className' => 'Cliente',
			'foreignKey' => 'usuario_cadastrou'
		),
		'Cliente_usuario_alterou' => array(
			'className' => 'Cliente',
			'foreignKey' => 'usuario_alterou'
		),
		'Fornecedor_usuario_cadastrou' => array(
			'className' => 'Fornecedor',
			'foreignKey' => 'usuario_cadastrou'
		),
		'Fornecedor_usuario_alterou' => array(
			'className' => 'Fornecedor',
			'foreignKey' => 'usuario_alterou'
		)
	);
	var $validate = array(
		'nome' => array(
			'allowEmpty' => false,
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'login' => array(
			'alphanumerico' => array(
				'allowEmpty' => false,
				'rule' => 'alphaNumeric',
				'message' => 'Somente letras e números.'
			),
			'unico' => array(
				'allowEmpty' => false,
				'rule' => 'isUnique',
				'message' => 'Já cadastrado.'
			)
		),
		'senha' => array(
			'allowEmpty' => false,
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'senha_confirma' => array(
			'allowEmpty' => false,
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'email' => array(
			'allowEmpty' => true,
			'rule' => array('email'),
			'message' => 'E-mail inválido.'
		),
		'permissao' => array(
			'allowEmpty' => false,
			'rule' => array('inList', array('0','1','2','3','4','5')),
			'message' => 'Campo obrigatório.'
		),
		'ativo' => array(
			'allowEmpty' => true,
			'rule' => array('boolean'),
			'message' => 'Valor incorreto.'
		)
	);
	
	
}

?>