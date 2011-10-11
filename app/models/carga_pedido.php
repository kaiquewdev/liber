<?php

class CargaPedido extends AppModel {
	var $name = 'CargaPedido';
	var $hasMany = array('Carga','PedidoVenda');
}

?>