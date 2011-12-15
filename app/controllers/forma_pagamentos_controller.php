<?php

class FormaPagamentosController extends AppController {
	var $name = 'FormaPagamentos';
	var $components = array('Sanitizacao','RequestHandler');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'FormaPagamento.id' => 'asc'
		)
	);
	
	function _obter_opcoes() {
		$this->loadModel('Conta');
		$contas = $this->Conta->find('all');
		$opcoes_contas = array();
		foreach ($contas as $c) {
			$opcoes_contas += array($c['Conta']['id']=>$c['Conta']['nome']);
		}
		$this->set('opcoes_contas',$opcoes_contas);
		
		$numero_maximo_parcelas = range(0, 50);
		$numero_maximo_parcelas[0] = 'A vista';
		$this->set('numero_maximo_parcelas',$numero_maximo_parcelas);
		
		$numero_parcelas_sem_juros = range(0, 50);
		$this->set('numero_parcelas_sem_juros',$numero_parcelas_sem_juros);
		
		#XXX colocar isso em num model e tornar uma opção padrao
		$dias_intervalo_parcelas = array(
			'0' => 'Não há',
			'1'=>'Uma por dia',
			'7'=>'Uma a cada semana',
			'15'=>'Uma a cada 15 dias',
			'21'=>'Uma a cada 21 dias',
			'30'=>'Uma por mês',
			'60'=>'Uma a cada dois meses',
			'90'=>'Uma a cada três meses',
			'120'=>'Uma a cada quatro meses',
			'180'=>'Uma a cada seis meses',
			'365'=>'Uma por ano',
			'730'=>'Uma a cada dois anos',
			'1095'=>'Uma a cada três anos'
		);
		$this->set('dias_intervalo_parcelas',$dias_intervalo_parcelas);
		
		$r = $this->FormaPagamento->TipoDocumento->find('list',array('fields'=>array('TipoDocumento.id','TipoDocumento.nome')));
		$this->set('opcoes_documentos',$r);
	}
	
	function index() {
		$dados = $this->paginate('FormaPagamento');
		$this->set('consulta_forma_pagamento',$dados);
	}
	
	function cadastrar() {
		
		$this->_obter_opcoes();
		
		if (! empty($this->data)) {
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->FormaPagamento->save($this->data)) {
				$this->Session->setFlash('Forma de pagamento cadastrada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar a forma de pagamento.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		$this->_obter_opcoes();
			
		if (empty ($this->data)) {
			$this->data = $this->FormaPagamento->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Forma de pagamento não encontrada.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$contas = $this->FormaPagamento->find();
				$this->set('contas',$contas);
			}
		}
		else {
			$this->data['FormaPagamento']['id'] = $id;
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->FormaPagamento->save($this->data)) {
				$this->Session->setFlash('Forma de pagamento atualizada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar a forma de pagamento.','flash_erro');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->FormaPagamento->delete($id)) $this->Session->setFlash("Forma de pagamento $id excluída com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Forma de pagamento $id não pode ser excluída.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Forma de pagamento não informada.','flash_erro');
		}
	}
	
	/**
	 * Retorna o numero maximo de parcelas definido para a forma de pagamento
	 * identificada pelo id $forma_pagamento_id
	 * 
	 * @param int $forma_pagamento_id 
	 * @return int
	 */
	function pesquisaAjaxNumeroMaximoParcelas ($forma_pagamento_id = null) {
		if (! isset($forma_pagamento_id)) $forma_pagamento_id = $this->params['url']['id'];
		if ( $this->RequestHandler->isAjax() ) {
   			Configure::write ('debug',0);
   			$this->autoRender=false;
			if (empty($forma_pagamento_id)) return null;
			$this->FormaPagamento->id = $forma_pagamento_id;
			$r = $this->FormaPagamento->field('numero_maximo_parcelas');
			if ($r === false) return null;
			else {
				$resultado = array('numero_maximo_parcelas'=>$r);
				print json_encode ($resultado);
			}
		}
	}
	
}

?>