<?php

class ClienteCategoriasController extends AppController {
	var $name = 'ClienteCategorias';
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'ClienteCategoria.id' => 'desc'
		)
	);
	
	function index() {
		$dados = $this->paginate('ClienteCategoria');
		$this->set('consulta',$dados);
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->ClienteCategoria->save($this->data)) {
				$this->Session->setFlash('Categoria de cliente cadastrada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar a categoria de cliente.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		if (empty ($this->data)) {
			$this->data = $this->ClienteCategoria->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Categoria de cliente não encontrada.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['ClienteCategoria']['id'] = $id;
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->ClienteCategoria->save($this->data)) {
				$this->Session->setFlash('Categoria de cliente atualizada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar a categoria de cliente.','flash_erro');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->ClienteCategoria->delete($id)) $this->Session->setFlash("Categoria de cliente $id excluída com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Categoria de cliente $id não pode ser excluída.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Categoria de cliente não informada.','flash_erro');
		}
	}
	
}

?>