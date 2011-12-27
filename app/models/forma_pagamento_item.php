<?php

class FormaPagamentoItem extends AppModel {
	var $name='FormaPagamentoItem';
	var $belongsTo = array(
		'FormaPagamento'
	);
}
	
?>