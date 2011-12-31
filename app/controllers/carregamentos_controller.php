<?php

/**
 * Carregamento tem as situacoes:
 * L => Livre
 * E => Enviado
 * 
 * #TODO No nomento o usuario marca o carregamento como enviado, quando houver
 * a rotina de faturamento, ao faturar será marcado como enviado
 */

class CarregamentosController extends AppController {
	var $name = 'Carregamentos';
	var $components = array('Sanitizacao','ContasReceber','Geral');
	var $helpers = array('CakePtbr.Formatacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Carregamento.id' => 'desc'
		)
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
		$this->set('opcoes_situacoes',array ('L' => 'Livre','E' => 'Enviado'));
	}
	
	function index() {
		$this->_obter_opcoes();
		$dados = $this->paginate('Carregamento');
		$this->set('consulta',$dados);
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			$this->data['Carregamento'] += array ('data_hora_criado' => date('Y-m-d H:i:s'));
			$this->data['Carregamento'] += array ('situacao' => 'L');
			
			$this->Carregamento->begin();
			
			if ($this->Carregamento->saveAll($this->data,array('validate'=>'first'))) {
				// atualiza a situacao dos pedidos para Travado
				foreach ($this->data['CarregamentoItem'] as $item) {
					$this->Carregamento->CarregamentoItem->PedidoVenda->id = $item['pedido_venda_id'];
					$situacao_pedido_venda = $this->Carregamento->CarregamentoItem->PedidoVenda->field('situacao');
					if (strtoupper($situacao_pedido_venda) != 'A') {
						$this->Session->setFlash("O pedido de venda ".$item['pedido_venda_id']." está sendo adicionado ao 
						carregamento mas sua situação não é 'Aberto'. Outro usuário pode ter editado o pedido de venda a
						pouco tempo.",'flash_erro');
						$this->Carregamento->rollback();
						break;
					}
					$r = $this->Carregamento->CarregamentoItem->PedidoVenda->save(array('PedidoVenda'=>array('situacao'=>'T')));
					if (! $r) {
						$this->setFlash('Erro ao atualizar os itens do carregamento','flash_erro');
						$this->Carregamento->rollback();
						break;
					}
				}
				
				$this->Carregamento->commit();
				$this->Session->setFlash('Carregamento cadastrado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar o carregamento.','flash_erro');
				$this->Carregamento->rollback();
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
			
			$carregamento = $this->Carregamento->read();
			if (! $carregamento) {
				$this->Session->setFlash('Carregamento não encontrado','flash_erro');
				$this->redirect(array('action'=>'index'));
				return null;
			}
			
			if (strtoupper($carregamento['Carregamento']['situacao']) != 'L') {
				$this->Session->setFlash('A situação do carregamento impede que seja excluído','flash_erro');
				$this->redirect(array('action'=>'index'));
				return NULL;
			} 
			
			if (empty($carregamento['CarregamentoItem'])) {
				$this->Session->setFlash('Carregamento não possui itens!','flash_erro');
				$this->redirect(array('action'=>'index'));
				return NULL;
			}
			$this->Carregamento->begin();
			// atualiza a situacao dos pedidos para Aberto
			foreach ($carregamento['CarregamentoItem'] as $item) {
				$this->Carregamento->CarregamentoItem->PedidoVenda->id = $item['id'];
				$r = $this->Carregamento->CarregamentoItem->PedidoVenda->save(array('PedidoVenda'=>array('situacao'=>'A')));
				if (! $r) {
					$this->Session->setFlash('Erro ao atualizar os itens do carregamento','flash_erro');
					$this->Carregamento->rollback();
					break;
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
				$this->Session->setFlash("Carregamento $id não encontrado",'flash_erro');
				$this->redirect(array('action'=>'index'));
			}
			else $this->set('carregamento',$r);
		}
		else {
			$this->Session->setFlash('Erro: nenhum carregamento informado.','flash_erro');
		}
	}
	
	function enviar() {
		if (empty($this->data)) {
			
		}
		else {
			$id=$this->data['Carregamento']['id'];
			
			$carregamento = $this->Carregamento->find('first',array('conditions'=>array('Carregamento.id'=>$id)));
			
			if (! $carregamento) {
				$this->Session->setFlash("Carregamento $id não encontrado.",'flash_erro');
				return false;
			}
			if (strtoupper($carregamento['Carregamento']['situacao']) != 'L' ) {
				$this->Session->setFlash("A situação do carregamento $id impede que seja enviado.",'flash_erro');
				return false;
			}
			
			// marco o(s) pedido(s) com a situacao vendido
			// futuramente, quando houver faturamento, os pedidos serao marcados
			// apenas depois de faturados
			$dados = array(
				'PedidoVenda' => array(
					'situacao' => 'V'
				)
			);
			
			$this->Carregamento->begin();
			foreach ($carregamento['CarregamentoItem'] as $c) {
				
				// gera conta a receber
				$pedido_venda = $this->Carregamento->CarregamentoItem->PedidoVenda->find('first',
					array('conditions'=>array('PedidoVenda.id'=>$c['pedido_venda_id']),'recursive'=>'-1' ) );
				$dados_conta_receber = array_merge (
					// quando o valor é recuperado do banco ele vem em formato pt-br. Converto para formato americano
					array('valor_total'=>$this->Geral->moeda2numero($pedido_venda['PedidoVenda']['valor_liquido'])),
					array('numero_documento'=>$c['pedido_venda_id']),
					$pedido_venda['PedidoVenda']
				);
				if ($this->ContasReceber->gerarContaReceber($dados_conta_receber) !== true) {
					$this->Session->setFlash("Erro ao gerar a conta a receber para o pedido ".$c['pedido_venda_id'].". Operação abortada",'flash_erro');
					$this->Carregamento->rollback();
					break;
				}
				
				// atualiza a situacao do pedido de venda
				$this->Carregamento->CarregamentoItem->PedidoVenda->id = $c	['pedido_venda_id'];
				if (! $this->Carregamento->CarregamentoItem->PedidoVenda->save($dados) ) {
					$this->Session->setFlash("Erro ao atualizar a situação do pedido de venda ".$c['pedido_venda_id'],'flash_erro');
					$this->Carregamento->rollback();
					break;
				}
			} //fim do loop
			$this->Carregamento->id = $id;
			$this->Carregamento->save(array('Carregamento'=>array('situacao'=>'E')));
			$this->Carregamento->commit();
			$this->Session->setFlash("Operação finalizada com sucesso para o carregamento $id.",'flash_sucesso');
			$this->data=NULL;
		}
		
	}
	
}

?>