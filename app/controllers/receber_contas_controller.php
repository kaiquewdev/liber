<?php

class ReceberContasController extends AppController {
	var $name = 'ReceberContas';
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'ReceberConta.id' => 'desc'
		)
	);
	var $opcoes_tipo_documento = array(''=>'');
	var $opcoes_conta_origem = array(''=>'');
	var $opcoes_plano_contas = array(''=>'');
	
	/**
	 * Obtem dados do banco e popula as variaveis globais
	 * $opcoes_tipo_documentos
	 * $opcoes_conta_origem
	 * $opcoes_plano_contas
	 */
	function _obter_opcoes() {
		$this->loadModel('TipoDocumento');
		$consulta1 = $this->TipoDocumento->find('all',array('fields'=>array('TipoDocumento.id','TipoDocumento.nome')));
		foreach ($consulta1 as $op)
			$this->opcoes_tipo_documento += array($op['TipoDocumento']['id']=>$op['TipoDocumento']['nome']);
		$this->set('opcoes_tipo_documento',$this->opcoes_tipo_documento);
		
		$this->loadModel('Conta');
		$consulta2 = $this->Conta->find('all');
		foreach ($consulta2 as $op)
			$this->opcoes_conta_origem += array($op['Conta']['id']=>$op['Conta']['apelido']);
		$this->set('opcoes_conta_origem',$this->opcoes_conta_origem);
		
		$this->loadModel('PlanoConta');
		$consulta3 = $this->PlanoConta->find('all');
		foreach ($consulta3 as $op)
			$this->opcoes_plano_contas += array($op['PlanoConta']['id']=>$op['PlanoConta']['nome']);
		$this->set('opcoes_plano_contas',$this->opcoes_plano_contas);
		return null;
	}
	
	function index() {
		$dados = $this->paginate('ReceberConta');
		$this->set('consulta_conta_receber',$dados);
	}
	
	function cadastrar() {
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			if (strtoupper($this->data['ReceberConta']['eh_cliente_ou_fornecedor']) == 'C') {
				$this->loadModel('Cliente');
				$r = $this->Cliente->find('first',
					array('conditions'=>array(
						'Cliente.id' => $this->data['ReceberConta']['cliente_fornecedor_id'],
						'Cliente.situacao' => 'A')));
				if (! empty($r)) $cliente_fornecedor_encontrado = true;
			}
			if (strtoupper($this->data['ReceberConta']['eh_cliente_ou_fornecedor']) == 'F') {
				$this->loadModel('Fornecedor');
				$r = $this->Fornecedor->find('first',
					array('conditions'=>array(
						'Fornecedor.id' => $this->data['ReceberConta']['cliente_fornecedor_id'],
						'Fornecedor.situacao' => 'A')));
				if (! empty($r)) $cliente_fornecedor_encontrado = true;
			}
			
			if ((! isset($cliente_fornecedor_encontrado)) || (! $cliente_fornecedor_encontrado)) {
				$this->Session->setFlash('Erro. Cliente/fornecedor não encontrado');
			}
			else {
				$this->data['ReceberConta'] += array ('data_hora_cadastrada' => date('Y-m-d H:i:s'));
				$this->data = $this->Sanitizacao->sanitizar($this->data);
				if ($this->ReceberConta->save($this->data)) {
					$this->Session->setFlash('Conta a receber cadastrada com sucesso.');
					$this->redirect(array('action'=>'index'));
				}
				else {
					$this->Session->setFlash('Erro ao cadastrar a conta a receber.');
				}
			}
		}
	}
	
	function editar($id=NULL) {
		$this->_obter_opcoes();
		$this->ReceberConta->id = $id;
		if (empty ($this->data)) {
			$this->data = $this->ReceberConta->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Conta a receber não encontrada.');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->ReceberConta->save($this->data)) {
				$this->Session->setFlash('Conta a receber atualizada com sucesso.');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar a conta a receber.');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->ReceberConta->delete($id)) $this->Session->setFlash("Conta a receber $id excluída com sucesso.");
			else $this->Session->setFlash("Conta a receber $id não pode ser excluída.");
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Conta a receber não informada.');
		}
	}
	
}

?>