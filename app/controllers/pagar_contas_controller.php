<?php

class PagarContasController extends AppController {
	var $name = 'PagarContas';
	var $components = array('Sanitizacao');
	var $helpers = array('CakePtbr.Formatacao','Javascript');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'PagarConta.id' => 'desc'
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
		
		$consulta4 = $this->PagarConta->Empresa->find('list',array('fields'=>array('Empresa.id','Empresa.nome')));
		$this->set('opcoes_empresas',$consulta4);
		
		$opcoes_situacoes = array (
			'N' => 'Não paga',
			'P' => 'Paga',
		);
		$this->set('opcoes_situacoes',$opcoes_situacoes);
		
		return null;
	}
	
	function index() {
		$dados = $this->paginate('PagarConta');
		$this->set('consulta_conta_pagar',$dados);
		$this->_obter_opcoes();
	}
	
	function cadastrar() {
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			if (strtoupper($this->data['PagarConta']['eh_cliente_ou_fornecedor']) == 'C') {
				$this->loadModel('Cliente');
				$r = $this->Cliente->find('first',
					array('conditions'=>array(
						'Cliente.id' => $this->data['PagarConta']['cliente_fornecedor_id'],
						'Cliente.situacao' => 'A')));
				if (! empty($r)) $cliente_fornecedor_encontrado = true;
			}
			else if (strtoupper($this->data['PagarConta']['eh_cliente_ou_fornecedor']) == 'F') {
				$this->loadModel('Fornecedor');
				$r = $this->Fornecedor->find('first',
					array('conditions'=>array(
						'Fornecedor.id' => $this->data['PagarConta']['cliente_fornecedor_id'],
						'Fornecedor.situacao' => 'A')));
				if (! empty($r)) $cliente_fornecedor_encontrado = true;
			}
			if ((! isset($cliente_fornecedor_encontrado)) || (! $cliente_fornecedor_encontrado)) {
				$this->Session->setFlash('Erro. Cliente/fornecedor não encontrado','flash_erro');
			}
			
			else {
				$this->data['PagarConta'] += array ('data_hora_cadastrada' => date('Y-m-d H:i:s'));
				
				if ($this->PagarConta->save($this->data)) {
					$this->Session->setFlash('Conta a pagar cadastrada com sucesso.','flash_sucesso');
					$this->redirect(array('action'=>'index'));
				}
				else {
					$this->Session->setFlash('Erro ao cadastrar a conta a pagar.','flash_erro');
				}
			}
		}
	}
	
	function editar($id=null) {
		$this->_obter_opcoes();
		if (empty ($this->data)) {
			$this->data = $this->PagarConta->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Conta a receber não encontrada.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->data['PagarConta']['data_vencimento'] = date('d/m/Y', strtotime($this->data['PagarConta']['data_vencimento']));
			}
		}
		else {
			$this->data['PagarConta']['id'] = $id;
			if (strtoupper($this->data['PagarConta']['eh_cliente_ou_fornecedor']) == 'C') {
				$this->loadModel('Cliente');
				$r = $this->Cliente->find('first',
					array('conditions'=>array(
						'Cliente.id' => $this->data['PagarConta']['cliente_fornecedor_id'],
						'Cliente.situacao' => 'A')));
				if (! empty($r)) $cliente_fornecedor_encontrado = true;
			}
			else if (strtoupper($this->data['PagarConta']['eh_cliente_ou_fornecedor']) == 'F') {
				$this->loadModel('Fornecedor');
				$r = $this->Fornecedor->find('first',
					array('conditions'=>array(
						'Fornecedor.id' => $this->data['PagarConta']['cliente_fornecedor_id'],
						'Fornecedor.situacao' => 'A')));
				if (! empty($r)) $cliente_fornecedor_encontrado = true;
			}
			if ((! isset($cliente_fornecedor_encontrado)) || (! $cliente_fornecedor_encontrado)) {
				$this->Session->setFlash('Erro. Cliente/fornecedor não encontrado','flash_erro');
			}
			
			else {
				if ($this->PagarConta->save($this->data)) {
					$this->Session->setFlash('Conta a pagar atualizada com sucesso.','flash_sucesso');
					$this->redirect(array('action'=>'index'));
				}
				else {
					$this->Session->setFlash('Erro ao atualizar a conta a pagar.','flash_erro');
				}
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->PagarConta->delete($id)) $this->Session->setFlash("Conta a pagar $id excluída com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Conta a pagar $id não pode ser excluída.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Conta a pagar não informada.','flash_erro');
		}
	}

	function pesquisar() {
		//#FIXME pesquisa por valor nao funciona se informar valor em notação brasileira ou valor contiver .
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			//usuario enviou os dados da pesquisa
			$url = array('controller'=>'pagarContas','action'=>'pesquisar');
			$params = array_merge($url,$this->data['PagarConta']);
			$this->redirect($params);
		}
		
		if (! empty($this->params['named'])) {
			//a instrucao acima redirecionou para cá
			$dados = $this->params['named'];
			$condicoes=array();
			if (! empty($dados['numero_documento'])) $condicoes[] = array('PagarConta.numero_documento'=>$dados['numero_documento']);
			if (! empty($dados['valor'])) $condicoes[] = array('PagarConta.valor'=>$dados['valor']);
			if (! empty($dados['eh_cliente_ou_fornecedor'])) $condicoes[] = array('PagarConta.eh_cliente_ou_fornecedor'=>$dados['eh_cliente_ou_fornecedor']);
			if (! empty($dados['cliente_fornecedor_id'])) $condicoes[] = array('PagarConta.cliente_fornecedor_id'=>$dados['cliente_fornecedor_id']);
			if (! empty($dados['id'])) $condicoes[] = array('PagarConta.id'=>$dados['id']);
			if (! empty($dados['tipo_documento'])) $condicoes[] = array('PagarConta.tipo_documento'=>$dados['tipo_documento']);
			if (! empty($dados['conta_origem'])) $condicoes[] = array('PagarConta.conta_origem'=>$dados['conta_origem']);
			if (! empty($dados['plano_conta_id'])) $condicoes[] = array('PagarConta.rg'=>$dados['plano_conta_id']);
			if (! empty($dados['situacao'])) $condicoes[] = array('PagarConta.situacao'=>$dados['situacao']);
			if (! empty ($condicoes)) {
				$resultados = $this->paginate('PagarConta',$condicoes);
				if (! empty($resultados)) {
					$num_encontrados = count($resultados);
					$this->set('resultados',$resultados);
					$this->set('num_resultados',$num_encontrados);
					$this->Session->setFlash("$num_encontrados conta(s) a pagar encontrada(s)",'flash_sucesso');
				}
				else $this->Session->setFlash("Nenhuma conta a pagar encontrada",'flash_erro'); 
			}
			else {
				$this->set('num_resultados','0');
				$this->Session->setFlash("Nenhum resultado encontrado",'flash_erro');
			}
		}
	}
	
}

?>