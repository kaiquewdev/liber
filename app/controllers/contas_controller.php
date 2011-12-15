<?php

class ContasController extends AppController {
	var $name = 'Contas';
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Conta.id' => 'asc'
		)
	);
	
	function index() {
		$dados = $this->paginate('Conta');
		$this->set('consulta_conta',$dados);
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			
			if ($this->Conta->save($this->data)) {
				$this->Session->setFlash('Conta cadastrada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar a conta.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		if (empty ($this->data)) {
			$this->data = $this->Conta->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Conta não encontrada.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['Conta']['id'] = $id;
			
			if ($this->Conta->save($this->data)) {
				$this->Session->setFlash('Conta atualizada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar a conta.','flash_erro');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->Conta->delete($id)) $this->Session->setFlash("Conta $id excluída com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Conta $id não pode ser excluída.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Conta não informada.','flash_erro');
		}
	}
	
}

?>