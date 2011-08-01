<?php

class ClientesController extends AppController {
	var $name = 'Clientes'; // PHP 4
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Cliente.id' => 'asc'
		)
	);
	
	
	function index() {
		$this->set('clientes',$this->Cliente->find('all'));
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			if ($this->Cliente->save($this->data)) {
				$this->Session->setFlash('Cliente cadastrado com sucesso.');
				$this->redirect(array('controller'=>'clientes'));
			}
		}
	}
	
	function consultar($id=null) {
		if (empty ($id)) {
			$dados = $this->paginate('Cliente');
		}
		else {
			$dados = $this->paginate('Cliente', array('Cliente.id = ' => $id) );
		}
		
		$this->set('consulta_cliente',$dados);
		
	}
	
	function detalhar($id = NULL) {
		$this->Cliente->id = $id;
		$this->set('cliente',$this->Cliente->read());
	}
	
}


?>