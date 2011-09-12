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
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->PlanoConta->save($this->data)) {
				$this->Session->setFlash('Item do plano de contas cadastrado com sucesso.');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar item do plano de contas.');
			}
		}
	}
	
	function editar($id=NULL) {
		if (empty ($this->data)) {
			$this->data = $this->PlanoConta->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Item do plano de contas não encontrado.');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['PlanoConta']['id'] = $id;
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->PlanoConta->save($this->data)) {
				$this->Session->setFlash('Plano de contas atualizado com sucesso.');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar o plano de contas.');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->PlanoConta->delete($id)) $this->Session->setFlash("Item $id do plano de contas excluído com sucesso.");
			else $this->Session->setFlash("Item $id do plano de contas não pode ser excluída.");
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Item do plano de contas não informado.');
		}
	}
	
}

?>