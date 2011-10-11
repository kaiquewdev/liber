<?php

class VeiculosController extends AppController {
	var $name = 'Veiculos';
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Veiculo.id' => 'asc'
		)
	);
	
	var $opcoes_veiculos = array(
		'' => '',
		'M' => 'Motocicleta',
		'C' => 'Carro',
		'A' => 'Caminhão',
		'R' => 'Carreta'
	);
	
	function index() {
		$dados = $this->paginate('Veiculo');
		$this->set('consulta_veiculo',$dados);
	}
	
	function cadastrar() {
		$this->set('tipos_veiculo',$this->opcoes_veiculos);
		if (! empty($this->data)) {
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->Veiculo->save($this->data)) {
				$this->Session->setFlash('Veiculo cadastrado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar o veículo.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		$this->set('tipos_veiculo',$this->opcoes_veiculos);
		if (empty ($this->data)) {
			$this->data = $this->Veiculo->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Veículo não encontrado.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['Veiculo']['id'] = $id;
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->Veiculo->save($this->data)) {
				$this->Session->setFlash('Veículo atualizado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar o veículo.','flash_erro');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->Veiculo->delete($id)) $this->Session->setFlash("Veículo $id excluído com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Veículo $id não pode ser excluído.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Veículo não informado.','flash_erro');
		}
	}
	
}

?>