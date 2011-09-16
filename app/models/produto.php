<?php

class Produto extends AppModel {
	var $name = 'Produto';
	var $belongsTo = array('CategoriaProduto');
	var $hasMany = array('LogEstoqueProduto');
	var $actsAs = array('AjusteFloat');
	var $validate = array(
		'nome' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'categoria_produto_id' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'tipo_produto' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'codigo_ean' => array(
			'allowEmpty' => true,
			'rule' => 'number',
			'message' => 'Campo obrigatório.'
		),
		'codigo_dun' => array(
			'allowEmpty' => true,
			'rule' => 'number',
			'message' => 'Campo obrigatório.'
		),
		'preco_custo' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'preco_venda' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'margem_lucro' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'tem_estoque_ilimitado' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'estoque_minimo' => array(
			'allowEmpty' => true,
			'rule' => 'number',
			'message' => 'Campo obrigatório.'
		),
		'unidade' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'quantidade_estoque_fiscal' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'quantidade_estoque_nao_fiscal' => array(
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