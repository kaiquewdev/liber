<?php

class Cliente extends AppModel {
	#FIXME corrigir o tipo de validação dos campos somente letras e numeros
	var $name = 'Cliente';
	var $belongsTo = array(
		'ClienteCategoria' => array(
			'className' => 'ClienteCategoria'
		),
		'Empresa' => array(
			'className' => 'Empresa'
		),
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_cadastrou',
		),
		'Usuario2' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_alterou',
		)
	);
	var $hasMany = array(
		'ServicoOrdem' => array(
			'className' => 'ServicoOrdem'
		),
		'PedidoVenda' => array(
			'className' => 'PedidoVenda'
		)
	);
	var $validate = array(
		'tipo_pessoa' => array (
			'allowEmpty' => false,
			'rule' => array('inList', array('F','J')),
			'message' => 'Escolha uma das opções.'
		),
		
		'situacao' => array (
			'allowEmpty' => false,
			'rule' => array('inList', array('A','I','B')),
			'message' => 'Escolha uma das opções.'
		),
		
		'nome' => array(
			'allowEmpty' => false,
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório. Somente letras e números.'
		),
		
		'nome_fantasia' => array(
			'allowEmpty' => false,
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório. Somente letras e números.'
		),
		
		'logradouro_nome' => array(
			'allowEmpty' => false,
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		
		'logradouro_numero' => array(
			'allowEmpty' => false,
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		
		'bairro' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		
		'cidade' => array(
			'allowEmpty' => false,
			'rule' => 'alphanumeric',
			'message' => 'Campo obrigatório. Somente letras e números.'
		),
		
		'uf' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		
		'cep' => array(
			'allowEmpty' => false,
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório. Somente números.'
		),
		
		'endereco_email' => array (
			'allowEmpty' => true,
			'rule' => 'email',
			'message' => 'Endereço de e-mail inválido.'
		),
		
		'cnpj' => array(
			'numerico' => array(
				'allowEmpty' => true,
				'rule' => 'numeric',
				'message' => 'Somente números.'
			),
			'unico' => array(
				'allowEmpty' => true,
				'rule' => 'isUnique',
				'message' => 'Já cadastrado.'
			)
		),
		
		'inscricao_estadual' => array(
			'numerico' => array(
				'allowEmpty' => true,
				'rule' => 'numeric',
				'message' => 'Somente números.'
			),
			'unico' => array(
				'allowEmpty' => true,
				'rule' => 'isUnique',
				'message' => 'Já cadastrado.'
			)
		),
		
		'cpf' => array(
			'numerico' => array(
				'allowEmpty' => true,
				'rule' => 'numeric',
				'message' => 'Somente números.'
			),
			'unico' => array(
				'allowEmpty' => true,
				'rule' => 'isUnique',
				'message' => 'Já cadastrado.'
			)
		),
		
		'rg' => array(
			'alphanumerico' => array(
				'allowEmpty' => true,
				'rule' => 'alphanumeric',
				'message' => 'Somente letras e números.'
			),
			'unico' => array(
				'allowEmpty' => true,
				'rule' => 'isUnique',
				'message' => 'Já cadastrado.'
			)
		),
		'empresa_id' => array(
			'allowEmpty' => false,
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		
	);
	
	
}

?>