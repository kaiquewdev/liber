<?php

class MotoristasController extends AppController {
	var $name = 'Motoristas';
	var $components = array('Sanitizacao','Geral');
	var $helpers = array('CakePtbr.Formatacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Motorista.id' => 'asc'
		)
	);
	var $opcoes_veiculo = array(''=>'');
	
	function _obter_opcoes() {
		$this->loadModel('Veiculo');
		$consulta1 = $this->Veiculo->find('all',array('fields'=>array('Veiculo.id','Veiculo.placa')));
		foreach ($consulta1 as $op)
			$this->opcoes_veiculo += array($op['Veiculo']['id']=>$op['Veiculo']['placa']);
		$this->set('opcoes_veiculo',$this->opcoes_veiculo);
	}
	
	function index() {
		$dados = $this->paginate('Motorista');
		$this->set('consulta_motorista',$dados);
	}
	
	function cadastrar() {
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if (isset($this->data['Motorista']['cnh_data_validade']) && ! empty($this->data['Motorista']['cnh_data_validade'])) {
				if (strtotime($this->Geral->AjustarData($this->data['Motorista']['cnh_data_validade'])) <= strtotime(date('Y-m-d'))) {
					$this->Session->setFlash('Data de validade da C.N.H. não pode ser menor ou igual a data atual.','flash_erro');
					return false;
				}
			}
			if ($this->Motorista->save($this->data)) {
				$this->Session->setFlash('Motorista cadastrado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar o motorista.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		$this->_obter_opcoes();
		if (empty ($this->data)) {
			$this->data = $this->Motorista->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Motorista não encontrado.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
			else {
				if ($this->data['Motorista']['cnh_data_validade'] == '0000-00-00') $this->data['Motorista']['cnh_data_validade'] = null;
				else $this->data['Motorista']['cnh_data_validade'] = date('d/m/Y', strtotime($this->data['Motorista']['cnh_data_validade']));
			}
		}
		else {
			$this->data['Motorista']['id'] = $id;
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if (isset($this->data['Motorista']['cnh_data_validade']) && ! empty($this->data['Motorista']['cnh_data_validade'])) {
				if (strtotime($this->Geral->AjustarData($this->data['Motorista']['cnh_data_validade'])) <= strtotime(date('Y-m-d'))) {
					$this->Session->setFlash('Data de validade da C.N.H. não pode ser menor ou igual a data atual.','flash_erro');
					return false;
				}
			}
			if ($this->Motorista->save($this->data)) {
				$this->Session->setFlash('Motorista atualizado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar o motorista.','flash_erro');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->Motorista->delete($id)) $this->Session->setFlash("Motorista $id excluído com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Motorista $id não pode ser excluído.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Motorista não informado.','flash_erro');
		}
	}
	
}

?>