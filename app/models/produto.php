<?php

class Produto extends AppModel {
	var $name = 'Produto';
	var $belongsTo = array('CategoriaProduto');
	var $actsAs = array('CakePtbr.AjusteFloat');
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
			'rule' => 'numeric',
			'message' => 'Campo obrigatório. Somente números.'
		),
		'codigo_dun' => array(
			'allowEmpty' => true,
			'rule' => 'numeric',
			'message' => 'Campo obrigatório. Somente números.'
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
			'rule' => 'numeric',
			'message' => 'Campo obrigatório. Somente números.'
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