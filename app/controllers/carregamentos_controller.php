<?php

/**
 * Carregamento tem as situacoes:
 * L => Livre
 * E => Enviado
 * 
 * No nomento o usuario marca o carregamento como enviado, quando houver
 * a rotina de faturamento, ao faturar será marcado como enviado
 */

class CarregamentosController extends AppController {
	var $name = 'Carregamentos';
	var $components = array('Sanitizacao');
	var $helpers = array('CakePtbr.Formatacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Carregamento.id' => 'asc'
		)
	);
	var $situacoes = array (
		'L' => 'Livre',
		'E' => 'Enviado',
	);
        
        /**
         * @var Carregamento
         */
        var $Carregamento;
	
	function _obter_opcoes() {
		$motoristas = $this->Carregamento->Motorista->find('list',array('fields'=>array('Motorista.id','Motorista.nome')));
		$veiculos = $this->Carregamento->Veiculo->find('list',array('fields'=>array('Veiculo.id','Veiculo.placa')));
		$this->set('opcoes_motoristas',$motoristas);
		$this->set('opcoes_veiculos',$veiculos);
		$this->set('opcoes_situacoes',$this->situacoes);
	}
	
	function index() {
		$this->_obter_opcoes();
		$dados = $this->paginate('Carregamento');
		$this->set('consulta',$dados);
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			$this->data['Carregamento'] += array ('data_hora_criado' => date('Y-m-d H:i:s'));
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->Carregamento->saveAll($this->data,array('validate'=>'first'))) {
				// marco o(s) pedido(s) com a situacao vendido
				// futuramente, quando houver faturamento, os pedidos serao marcados
				// apenas depois de faturados
				#XXX utilizar transaction
				$dados = array(
					'PedidoVenda' => array(
						'situacao' => 'V'
					)
				);
				foreach ($this->data['CarregamentoItem'] as $c) {
					$this->Carregamento->CarregamentoItem->PedidoVenda->id = $c['pedido_venda_id'];
					$this->Carregamento->CarregamentoItem->PedidoVenda->save($dados);
				}
				$this->Session->setFlash('Carregamento cadastrado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar o carregamento.','flash_erro');
			}
		}
		else {
			// O carregamento será montado com os pedidos que estao em aberto
			$consulta = $this->Carregamento->CarregamentoItem->PedidoVenda->find('all',array('conditions'=>array('PedidoVenda.situacao'=>'A')));
			$this->set('consulta_pedidos',$consulta);
			$this->_obter_opcoes();
		}
	}
	
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			$this->Carregamento->id = $id;
			// Inicio a transação
			$this->Carregamento->begin();
			
			if (! $this->Carregamento->read()) {
				$this->Session->setFlash('Carregamento não encontrado','flash_erro');
				return NULL;
			}
			
			$carregamentoItems = $this->Carregamento->CarregamentoItem->find('all',array('conditions'=>array('CarregamentoItem.carregamento_id'=>$id)));
			if (empty($carregamentoItems)) {
				$this->Session->setFlash('Carregamento não possui itens!','flash_erro');
				return NULL;
			}
			foreach ($carregamentoItems as $item) {
				$this->Carregamento->CarregamentoItem->PedidoVenda->id = $item['PedidoVenda']['id'];
				$r = $this->Carregamento->CarregamentoItem->PedidoVenda->save(array('PedidoVenda'=>array('situacao'=>'A')));
				if (! $r) {
					$this->setFlash('Erro ao atualizar os itens do carregamento','flash_erro');
					$this->Carregamento->rollback();
					exit;
				}
			}
			
			if ($this->Carregamento->CarregamentoItem->deleteAll(array('CarregamentoItem.carregamento_id'=>$id))) {
				if ($this->Carregamento->delete($id)) {
					$this->Session->setFlash("Carregamento $id excluído com sucesso.",'flash_sucesso');
					$this->Carregamento->commit();
				}
			}
			else {
				$this->Carregamento->rollback();
				$this->Session->setFlash("Carregamento $id não pode ser excluído.",'flash_erro');
			}
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Carregamento não informado.','flash_erro');
		}
	}
	
	function pesquisar() {
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			//usuario enviou os dados da pesquisa
			$url = array('controller'=>'Carregamentos','action'=>'pesquisar');
			//convertendo caracteres especiais
			if( isset($this->data['Carregamento']) && is_array($this->data['Carregamento']) ) {
				foreach($this->data['Carregamento'] as &$carregamento) {
					$carregamento = urlencode($carregamento);
				}
				$params = array_merge($url,$this->data['Carregamento']);
			}
			if(isset($this->data['Motorista']) && is_array($this->data['Motorista']) ) {
				foreach($this->data['Motorista'] as &$motorista) {
					$motorista = urlencode($motorista);
				}
				$params = array_merge($params,$this->data['Motorista']);
			}
			if( isset($this->data['Veiculo']) && is_array($this->data['Veiculo']) ) {
				foreach($this->data['Veiculo'] as &$veiculo) {
					$veiculo = urlencode($veiculo);
				}
				$params = array_merge($params,$this->data['Veiculo']);
			}
			if (! isset($params) ) $params = $url;
			
			$this->redirect($params);
		}
		
		if (! empty($this->params['named'])) {
			//a instrucao acima redirecionou para cá
			$dados = $this->params['named'];
			$condicoes=array();
			if (! empty($dados['data_inicial'])) $condicoes[] = array('Carregamento.data_hora_criado LIKE'=>'%'.$dados['data_inicial'].'%');
			if (! empty($dados['data_final'])) $condicoes[] = array('Carregamento.data_hora_criado LIKE'=>'%'.$dados['data_final'].'%');
			if (! empty($dados['situacao'])) $condicoes[] = array('Carregamento.situacao'=>$dados['situacao']);
			if (! empty($dados['descricao'])) $condicoes[] = array('Carregamento.descricao'=>$dados['descricao']);
			if (! empty($dados['motorista'])) $condicoes[] = array('Motorista.id'=>$dados['motorista']);
			if (! empty($dados['veiculo'])) $condicoes[] = array('Veiculo.id'=>$dados['veiculo']);
			if (! empty ($condicoes)) {
				$resultados = $this->paginate('Carregamento',$condicoes);
				if (! empty($resultados)) {
					$num_encontrados = count($resultados);
					$this->set('resultados',$resultados);
					$this->set('num_resultados',$num_encontrados);
					$this->Session->setFlash("$num_encontrados carregamento(s) encontrado(s)",'flash_sucesso');
				}
				else $this->Session->setFlash("Nenhum carregamento encontrado",'flash_erro');
			}
			else {
				$this->set('num_resultados','0');
				$this->Session->setFlash("Nenhum resultado encontrado",'flash_erro');
			}
		}
	}

	function detalhar($id = NULL) {
		if ($id) {
			$this->Carregamento->id = $id;
			$r = $this->Carregamento->read();
			if (empty($r)) {
				$this->Session->setFlash("Carregamento $id não encontrado");
				return null;
			}
			else $this->set('carregamento',$r);
		}
		else {
			$this->Session->setFlash('Erro: nenhum carregamento informado.','flash_erro');
		}
	}
	
	/**
	 * Principal action para relatórios, ela é responsavel
	 * por chamar o metodo apropriado para a geração do relatório.
	 */
	function relatorios ($relatorio = NULL) {
		if (empty ($relatorio)) {
			$this->Session->setFlash('Relatório não informado','flash_erro');
			$this->redirect(array('action'=>'index'));
			return NULL;
		}
		
		if (strtoupper($relatorio) == 'PEDIDOSPORCARREGAMENTO') {
			
		}
	}
	
}

?>