<?php

class CategoriaProduto extends AppModel {
	var $name = 'CategoriaProduto';
	var $hasMany = array('Produto');
	var $validate = array(
		'nome' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		)
	);
}

?>