<?php

class CarregamentoItem extends AppModel {
	var $name = 'CarregamentoItem';
	var $belongsTo = array('Carregamento','PedidoVenda');
}

?>