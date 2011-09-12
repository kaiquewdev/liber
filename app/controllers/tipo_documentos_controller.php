<?php

class TipoDocumentosController extends AppController {
	var $name = 'TipoDocumentos';
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'TipoDocumento.nome' => 'asc'
		)
	);
	
	function index() {
		$dados = $this->paginate('TipoDocumento');
		$this->set('consulta_tipo_documento',$dados);
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->TipoDocumento->save($this->data)) {
				$this->Session->setFlash('Tipo de documento cadastrado com sucesso.');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar tipo de documento.');
			}
		}
	}
	
	function editar($id=NULL) {
		if (empty ($this->data)) {
			$this->data = $this->TipoDocumento->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Tipo de documento não encontrado.');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['TipoDocumento']['id'] = $id;
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->TipoDocumento->save($this->data)) {
				$this->Session->setFlash('Tipo de documento atualizado com sucesso.');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar o Tipo de documento.');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->TipoDocumento->delete($id)) $this->Session->setFlash("Tipo de documento $id excluído com sucesso.");
			else $this->Session->setFlash("Tipo de documento $id não pode ser excluído.");
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Tipo de documento não informado.');
		}
	}
	
}

?>