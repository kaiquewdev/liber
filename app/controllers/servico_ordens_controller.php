<?php

class ServicoOrdensController extends AppController {
	var $name = 'ServicoOrdens';
	var $components = array('Sanitizacao','RequestHandler');
	var $helpers = array('Estados','Ajax', 'Javascript');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'ServicoOrdem.id' => 'asc'
		)
	);
	
	var $opcoes_tecnico = array(''=>'');
	var $opcoes_forma_pamamento = array(''=>'');
	
	/**
	 * Obtem dados do banco e popula as variaveis globais
	 * $opcoes_tecnico
	 * $opcoes_forma_pamamento
	 */
	function _obter_opcoes() {
		$this->loadModel('Usuario');
		$consulta1 = $this->Usuario->find('all',array('fields'=>array('Usuario.id','Usuario.nome')));
		foreach ($consulta1 as $op)
			$this->opcoes_tecnico += array($op['Usuario']['id']=>$op['Usuario']['nome']);
		$this->set('opcoes_tecnico',$this->opcoes_tecnico);
		
		$this->loadModel('FormaPagamento');
		$consulta2 = $this->FormaPagamento->find('all',array('fields'=>array('FormaPagamento.id','FormaPagamento.nome')));
		foreach ($consulta2 as $op)
			$this->opcoes_forma_pamamento += array($op['FormaPagamento']['id']=>$op['FormaPagamento']['nome']);
		$this->set('opcoes_forma_pamamento',$this->opcoes_forma_pamamento);
		
	}
		
	
	function index() {
		$dados = $this->paginate('ServicoOrdem');
		$this->set('consulta',$dados);
	}
	
	function cadastrar() {
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			debug ($this->data['data_hora_inicio']);
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->ServicoOrdem->saveAll($this->data,array('validate'=>'first'))) {
				$this->Session->setFlash('Ordem de serviço cadastrada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar a ordem de serviço.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		$this->_obter_opcoes();
		if (empty ($this->data)) {
			$this->data = $this->ServicoOrdem->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Ordem de serviço não encontrada.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['ServicoOrdem']['id'] = $id;
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->ServicoOrdem->save($this->data)) {
				$this->Session->setFlash('Ordem de serviço atualizada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar a ordem de serviço.','flash_erro');
			}
		}
	}
	
	function pesquisaAjaxCliente($termo = null) {
		if (! isset($termo)) $termo = $this->params['url']['term'];
		if ( $this->RequestHandler->isAjax() ) {
			$i=0;
			$resultados=array();
			$retorno=array();
			$r = array();
   			Configure::write ('debug',0);
   			$this->autoRender=false;
			$this->loadModel('Cliente');
			$resultados = $this->Cliente->find('all',array('fields' => array('id','nome'),
			'conditions'=>array('Cliente.nome LIKE' => '%'.$termo.'%')));
			if (!empty($resultados)) {
				foreach ($resultados as $r) {
					$retorno[$i]['label'] = $r['Cliente']['nome'];
					$retorno[$i]['value'] = $r['Cliente']['id'];
					$i++; 
				}
				print json_encode($retorno);
			}
		}
	}
	
	function pesquisaAjaxServico($campo_a_pesquisar,$termo = null) {
		if (strtoupper($campo_a_pesquisar) == "NOME") $campo = 'nome';
		else if (strtoupper($campo_a_pesquisar) == "CODIGO") $campo = 'id';
		else return null;
		if (! isset($termo)) $termo = $this->params['url']['term'];
		if ( $this->RequestHandler->isAjax() ) {
			$i=0;
			$resultados=array();
			$retorno=array();
			$r = array();
   			Configure::write ('debug',0);
   			$this->autoRender=false;
			$this->loadModel('Servico');
			$resultados = $this->Servico->find('all',array('fields' => array('id','nome','valor'),
			'conditions'=>array("Servico.$campo LIKE" => '%'.$termo.'%')));
			if (!empty($resultados)) {
				foreach ($resultados as $r) {
					$retorno[$i]['label'] = $r['Servico']['nome'];
					$retorno[$i]['value'] = $r['Servico'][$campo];
					$retorno[$i]['id'] = $r['Servico']['id'];
					$retorno[$i]['valor'] = $r['Servico']['valor'];
					$i++; 
				}
				print json_encode($retorno);
			}
		}
	}
}

?>