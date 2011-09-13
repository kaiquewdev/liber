<?php

class FornecedorCategoria extends AppModel {
	var $name = 'FornecedorCategoria';
	var $hasMany = array('Fornecedor');
	var $validate = array(
		'descricao' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		)
	);
}

?>