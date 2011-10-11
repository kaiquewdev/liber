<?php

class Carga extends AppModel {
	var $name = 'Carga';
	var $belongsTo = array('CargaPedido');
	var $validate = array(
		'situacao' => array(
			'rule' => 'notEmpty',
			'message' => 'Campo obrigatório.'
		)
	);
}

?>