<?php

class CategoriaProdutosController extends AppController {
	var $name = 'CategoriaProdutos';
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'CategoriaProduto.id' => 'asc'
		)
	);
	
	function index() {
		$dados = $this->paginate('CategoriaProduto');
		$this->set('consulta',$dados);
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->CategoriaProduto->save($this->data)) {
				$this->Session->setFlash('Categoria de produto cadastrada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar a categoria de produto.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		if (empty ($this->data)) {
			$this->data = $this->CategoriaProduto->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Categoria de produto não encontrada.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['CategoriaProduto']['id'] = $id;
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->CategoriaProduto->save($this->data)) {
				$this->Session->setFlash('Categoria de produto atualizada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar a categoria de produto.');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->CategoriaProduto->delete($id)) $this->Session->setFlash("Categoria de produto $id excluída com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Categoria de produto $id não pode ser excluída.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Categoria de produto não informada.','flash_erro');
		}
	}
	
}

?>