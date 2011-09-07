<?php

class Conta extends AppModel {
	var $name='Conta';
	var $validate = array(
		'nome' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'apelido' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		),
		'titular' => array(
			'allowEmpty' => true,
			'rule' => 'alphanumeric',
			'message' => 'Somente letras e números.'
		)
	);
}

?>