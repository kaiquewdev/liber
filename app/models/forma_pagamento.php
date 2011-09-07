<?php

class FormaPagamento extends AppModel {
	var $name='FormaPagamento';
	var $belongsTo = array(
		'Conta' => array(
			'className' => 'Conta',
			'foreignKey' => 'conta_principal'
		)
	);
	var $validate = array(
		'nome' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'numero_maximo_parcelas' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'numero_parcelas_sem_juros' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'dias_intervalo_parcelamento' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'porcentagem_juros' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'valor_taxa_fixa' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'porcentagem_desconto_a_vista' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'conta_principal' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		)
	);
}

?>