<?php

class EmpresasController extends AppController {
	var $name = 'Empresas';
	var $components = array('Sanitizacao');
	var $helpers = array('Estados');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Empresa.id' => 'asc'
		)
	);
	
	function index() {
		$dados = $this->paginate('Empresa');
		$this->set('consulta_empresa',$dados);
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->Empresa->save($this->data)) {
				$this->Session->setFlash('Empresa cadastrada com sucesso.');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar a conta.');
			}
		}
	}
	
	function editar($id=NULL) {
		if (empty ($this->data)) {
			$this->data = $this->Empresa->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Empresa não encontrada.');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['Empresa']['id'] = $id;
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->Empresa->save($this->data)) {
				$this->Session->setFlash('Empresa atualizada com sucesso.');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar a conta.');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->Empresa->delete($id)) $this->Session->setFlash("Empresa $id excluída com sucesso.");
			else $this->Session->setFlash("Empresa $id não pode ser excluída.");
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Empresa não informada.');
		}
	}
	
}

?>