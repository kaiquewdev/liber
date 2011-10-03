<?php
class Servico extends AppModel {
	var $name = 'Servico';
	var $actsAs = array('AjusteFloat');
	var $belongsTo = array(
		'ServicoCategoria' => array(
			'className' => 'ServicoCategoria',
			'foreignKey' => 'servico_categoria_id'
		)
	);
	var $hasMany = array(
		'ServicoOrdemItem' => array(
			'className' => 'ServicoOrdemItem',
			'foreignKey' => 'servico_id',
			'dependent' => false
		)
	);
	var $validate = array(
		'id' => array(
			'notempty' => array(
				'rule' => array('notempty')
			)
		),
		'nome' => array(
			'notempty' => array(
				'rule' => array('notempty')
			)
		),
		'servico_categoria_id' => array(
			'notempty' => array(
				'rule' => array('notempty')
			)
		),
		'valor' => array(
			'notempty' => array(
				'rule' => array('notempty')
			)
		)
	);

}
