<?php

class FornecedorCategoriasController extends AppController {
	var $name = 'FornecedorCategorias';
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'FornecedorCategoria.id' => 'asc'
		)
	);
	
	function index() {
		$dados = $this->paginate('FornecedorCategoria');
		$this->set('consulta',$dados);
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->FornecedorCategoria->save($this->data)) {
				$this->Session->setFlash('Categoria de fornecedor cadastrada com sucesso.');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar a categoria de fornecedor.');
			}
		}
	}
	
	function editar($id=NULL) {
		if (empty ($this->data)) {
			$this->data = $this->FornecedorCategoria->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Categoria de fornecedor não encontrada.');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['FornecedorCategoria']['id'] = $id;
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->FornecedorCategoria->save($this->data)) {
				$this->Session->setFlash('Categoria de fornecedor atualizada com sucesso.');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar a categoria de fornecedor.');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->FornecedorCategoria->delete($id)) $this->Session->setFlash("Categoria de fornecedor $id excluída com sucesso.");
			else $this->Session->setFlash("Categoria de fornecedor $id não pode ser excluída.");
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Categoria de fornecedor não informada.');
		}
	}
	
}

?>