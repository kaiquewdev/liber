<?php
class ServicoOrdemItem extends AppModel {
	var $name = 'ServicoOrdemItem';
	var $actsAs = array('AjusteFloat');

	var $belongsTo = array(
		'ServicoOrdem' => array(
			'className' => 'ServicoOrdem',
			'foreignKey' => 'servico_ordem_id'
		),
		'Servico' => array(
			'className' => 'Servico',
			'foreignKey' => 'servico_id'
		)
	);
}
