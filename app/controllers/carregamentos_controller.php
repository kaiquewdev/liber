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
	
	function _obter_opcoes() {
		$motoristas = $this->Carregamento->Motorista->find('list',array('fields'=>array('Motorista.id','Motorista.nome')));
		$veiculos = $this->Carregamento->Veiculo->find('list',array('fields'=>array('Veiculo.id','Veiculo.placa')));
		$this->set('opcoes_motoristas',$motoristas);
		$this->set('opcoes_veiculos',$veiculos);
	}
	
	function index() {
		$dados = $this->paginate('Carregamento');
		$this->set('consulta',$dados);
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			$this->data['Carregamento'] += array ('data_hora_criado' => date('Y-m-d H:i:s'));
			$this->data['Carregamento'] += array ('situacao' => 'L');
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
			// O carregamento serah montado com os pedidos que estao em aberto
			$consulta = $this->Carregamento->CarregamentoItem->PedidoVenda->find('all',array('conditions'=>array('PedidoVenda.situacao'=>'A')));
			$this->set('consulta_pedidos',$consulta);
			$this->_obter_opcoes();
		}
	}
	
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->Carregamento->delete($id)) $this->Session->setFlash("Carregamento $id excluído com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Carregamento $id não pode ser excluído.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Carregamento não informado.','flash_erro');
		}
	}
	
	function pesquisar() {
		
		if (! empty($this->data)) {
			//usuario enviou os dados da pesquisa
			$url = array('controller'=>'Clientes','action'=>'pesquisar');
			//convertendo caracteres especiais
			if( is_array($this->data['Cliente']) ) {
				foreach($this->data['Cliente'] as &$cliente) {
					$cliente = urlencode($cliente);
				}
			}
			$params = array_merge($url,$this->data['Cliente']);
			$this->redirect($params);
		}
		
		if (! empty($this->params['named'])) {
			//a instrucao acima redirecionou para cá
			$dados = $this->params['named'];
			$condicoes=array();
			if (! empty($dados['nome'])) $condicoes[] = array('Cliente.nome LIKE'=>'%'.$dados['nome'].'%');
			if (! empty($dados['nome_fantasia'])) $condicoes[] = array('Cliente.nome_fantasia LIKE'=>'%'.$dados['nome_fantasia'].'%');
			if (! empty($dados['bairro'])) $condicoes[] = array('Cliente.bairro'=>$dados['bairro']);
			if (! empty($dados['cidade'])) $condicoes[] = array('Cliente.cidade'=>$dados['cidade']);
			if (! empty($dados['cnpj'])) $condicoes[] = array('Cliente.cnpj'=>$dados['cnpj']);
			if (! empty($dados['inscricao_estadual'])) $condicoes[] = array('Cliente.inscricao_estadual'=>$dados['inscricao_estadual']);
			if (! empty($dados['cpf'])) $condicoes[] = array('Cliente.cpf'=>$dados['cpf']);
			if (! empty($dados['rg'])) $condicoes[] = array('Cliente.rg'=>$dados['rg']);
			if (! empty ($condicoes)) {
				$resultados = $this->paginate('Cliente',$condicoes);
				if (! empty($resultados)) {
					$num_encontrados = count($resultados);
					$this->set('resultados',$resultados);
					$this->set('num_resultados',$num_encontrados);
					$this->Session->setFlash("$num_encontrados cliente(s) encontrado(s)",'flash_sucesso');
				}
				else $this->Session->setFlash("Nenhum cliente encontrado",'flash_erro');
			}
			else {
				$this->set('num_resultados','0');
				$this->Session->setFlash("Nenhum resultado encontrado",'flash_erro');
			}
		}
	}
	
}

?>