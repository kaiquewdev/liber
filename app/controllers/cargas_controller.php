<?php

class CargasController extends AppController {
	var $name = 'Cargas';
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Carga.id' => 'asc'
		)
	);
	
	function index() {
		$dados = $this->paginate('Carga');
		$this->set('consulta_carga',$dados);
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->Carga->save($this->data)) {
				$this->Session->setFlash('Carga cadastrada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar a carga.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		if (empty ($this->data)) {
			$this->data = $this->Carga->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Carga não encontrada.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['Carga']['id'] = $id;
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->Carga->save($this->data)) {
				$this->Session->setFlash('Carga atualizada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar a carga.','flash_erro');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->Carga->delete($id)) $this->Session->setFlash("Carga $id excluída com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Carga $id não pode ser excluída.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Carga não informada.','flash_erro');
		}
	}
	
}

?>