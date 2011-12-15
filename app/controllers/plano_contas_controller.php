<?php

class PlanoContasController extends AppController {
	var $name = 'PlanoContas';
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 30,
		'order' => array (
			'PlanoConta.nome' => 'asc'
		)
	);
	
	function index() {
		$dados = $this->paginate('PlanoConta');
		$this->set('consulta_plano_contas',$dados);
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			
			if ($this->PlanoConta->save($this->data)) {
				$this->Session->setFlash('Item do plano de contas cadastrado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar item do plano de contas.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		if (empty ($this->data)) {
			$this->data = $this->PlanoConta->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Item do plano de contas não encontrado.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['PlanoConta']['id'] = $id;
			
			if ($this->PlanoConta->save($this->data)) {
				$this->Session->setFlash('Plano de contas atualizado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar o plano de contas.','flash_erro');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->PlanoConta->delete($id)) $this->Session->setFlash("Item $id do plano de contas excluído com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Item $id do plano de contas não pode ser excluída.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Item do plano de contas não informado.','flash_erro');
		}
	}
	
}

?>