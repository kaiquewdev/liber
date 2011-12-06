<?php

class ClienteCategoria extends AppModel {
	var $name = 'ClienteCategoria';
	var $hasMany = array('Cliente');
	var $validate = array(
		'descricao' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		)
	);
}

?>