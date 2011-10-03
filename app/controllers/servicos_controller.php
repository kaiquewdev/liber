<?php

class ServicosController extends AppController {
	var $name = 'Servicos';
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Servico.id' => 'desc'
		)
	);
	var $opcoes_servico_categoria = array();
	
	/**
	 * Obtem dados do banco e popula as variaveis globais
	 * $opcoes_servico_categoria
	 */
	function _obter_opcoes() {
		$this->loadModel('ServicoCategoria');
		$consulta1 = $this->ServicoCategoria->find('all',array('fields'=>array('ServicoCategoria.id','ServicoCategoria.nome')));
		foreach ($consulta1 as $op)
			$this->opcoes_servico_categoria += array($op['ServicoCategoria']['id']=>$op['ServicoCategoria']['nome']);
		$this->set('opcoes_servico_categoria',$this->opcoes_servico_categoria);
		
		return null;
	}
	
	
	function index() {
		$dados = $this->paginate('Servico');
		$this->set('consulta',$dados);
	}
	
	function cadastrar() {
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->Servico->save($this->data)) {
				$this->Session->setFlash('Serviço cadastrado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar o serviço.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		$this->_obter_opcoes();
		if (empty ($this->data)) {
			$this->data = $this->Servico->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Serviço não encontrado.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['Servico']['id'] = $id;
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->Servico->save($this->data)) {
				$this->Session->setFlash('Serviço atualizado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar o serviço.','flash_erro');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->Servico->delete($id)) $this->Session->setFlash("Serviço $id excluído com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Serviço $id não pode ser excluído.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Serviço não informado.','flash_erro');
		}
	}
	
}

?>