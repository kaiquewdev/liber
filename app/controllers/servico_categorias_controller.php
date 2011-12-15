<?php

class ServicoCategoriasController extends AppController {
	var $name = 'ServicoCategorias';
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'ServicoCategoria.id' => 'desc'
		)
	);
	
	function index() {
		$dados = $this->paginate('ServicoCategoria');
		$this->set('consulta',$dados);
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			
			if ($this->ServicoCategoria->save($this->data)) {
				$this->Session->setFlash('Categoria de serviço cadastrada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar a categoria de serviço.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		if (empty ($this->data)) {
			$this->data = $this->ServicoCategoria->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Categoria de serviço não encontrada.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['ServicoCategoria']['id'] = $id;
			
			if ($this->ServicoCategoria->save($this->data)) {
				$this->Session->setFlash('Categoria de serviço atualizada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar a categoria de serviço.','flash_erro');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->ServicoCategoria->delete($id)) $this->Session->setFlash("Categoria de serviço $id excluída com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Categoria de serviço $id não pode ser excluída.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Categoria de serviço não informada.','flash_erro');
		}
	}
	
}

?>