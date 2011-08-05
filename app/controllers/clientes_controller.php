<?php

class ClientesController extends AppController {
	var $name = 'Clientes'; // PHP 4
	var $helpers = array('Estados');
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Cliente.id' => 'asc'
		)
	);
	
	function index() {
		$this->set('clientes',$this->Cliente->find('all'));
	}
	
	function cadastrar($id=null) {
		if (empty ($id)) { //cadastrando cliente
			if (! empty($this->data)) {
				$this->data = $this->Sanitizacao->sanitizar($this->data);
				if ($this->Cliente->save($this->data)) {
					$this->Session->setFlash('Cliente cadastrado com sucesso.');
					$this->redirect(array('controller'=>'clientes'));
				}
				else {
					$this->Session->setFlash('Erro ao cadastrar o cliente.');
				}
			}
		}
		else { //atualizando cliente
			$this->Cliente->id = $id;
			if (empty ($this->data)) {
				$this->data = $this->Cliente->read();
			}
			else {
				$this->data = $this->Sanitizacao->sanitizar($this->data);
				if ($this->Cliente->save($this->data)) {
					$this->Session->setFlash('Cliente atualizado com sucesso.');
					$this->redirect(array('controller'=>'clientes'));
				}
				else {
					$this->Session->setFlash('Erro ao atualizar o cliente.');
				}
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