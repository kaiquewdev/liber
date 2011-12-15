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
			
			if ($this->TipoDocumento->save($this->data)) {
				$this->Session->setFlash('Tipo de documento cadastrado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar tipo de documento.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		if (empty ($this->data)) {
			$this->data = $this->TipoDocumento->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Tipo de documento não encontrado.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['TipoDocumento']['id'] = $id;
			
			if ($this->TipoDocumento->save($this->data)) {
				$this->Session->setFlash('Tipo de documento atualizado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar o Tipo de documento.','flash_erro');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->TipoDocumento->delete($id)) $this->Session->setFlash("Tipo de documento $id excluído com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Tipo de documento $id não pode ser excluído.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Tipo de documento não informado.','flash_erro');
		}
	}
	
}

?>