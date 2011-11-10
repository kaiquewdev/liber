<?php
/**
 * A pedido de venda tem as seguintes situações:
 * O = Orçamento
 * E = Em espera
 * X = Em execução
 * F = Finalizada
 * E = Entregue
 * C = Cancelada
 */

//#TODO criar alerta caso o(s) pedido(s) totalize(m) um valor maior que o limite de credito  
class PedidoVendasController extends AppController {
	var $name = 'PedidoVendas';
	var $components = array('Sanitizacao','Geral');
	var $helpers = array('CakePtbr.Estados', 'Javascript','CakePtbr.Formatacao','Geral');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'PedidoVenda.id' => 'desc'
		)
	);
	
	var $opcoes_forma_pamamento = array(''=>'');
	
	/**
	 * Obtem dados do banco e popula as variaveis globais
	 * $opcoes_forma_pamamento
	 */
	function _obter_opcoes() {
		
		$this->loadModel('FormaPagamento');
		$consulta2 = $this->FormaPagamento->find('all',array('fields'=>array('FormaPagamento.id','FormaPagamento.nome')));
		foreach ($consulta2 as $op)
			$this->opcoes_forma_pamamento += array($op['FormaPagamento']['id']=>$op['FormaPagamento']['nome']);
		$this->set('opcoes_forma_pamamento',$this->opcoes_forma_pamamento);
		
	}
	
	function _obter_opcoes_pesquisa() {
		$this->loadModel('Usuario');
		$consulta1 = $this->Usuario->find('all',array('fields'=>array('Usuario.id','Usuario.nome'),
		'conditions'=>array('Usuario.eh_tecnico'=>'1','Usuario.ativo'=>'1')));
		foreach ($consulta1 as $op)
			$this->opcoes_tecnico += array($op['Usuario']['id']=>$op['Usuario']['nome']);
		$this->set('opcoes_tecnico',$this->opcoes_tecnico);
		
		$consulta2 = $this->Usuario->find('all',array('fields'=>array('Usuario.id','Usuario.nome'),
		'conditions'=>array('Usuario.ativo'=>'1')));
		foreach ($consulta2 as $op)
			$this->opcoes_usuarios += array($op['Usuario']['id']=>$op['Usuario']['nome']);
		$this->set('opcoes_usuarios',$this->opcoes_usuarios);
	}	
	
	function index() {
		$dados = $this->paginate('PedidoVenda');
		$this->set('consulta',$dados);
	}
	
	/**
	* caso algum produto seja enviado (erro na validacao, editando registro, etc),
	* o insiro na pagina
	*/
	function _recupera_produtos_inseridos($data) {
		if (isset($data['PedidoVendaItem'])) {
			$itens = $data['PedidoVendaItem'];
			$i = 0;
			$valor_total = 0;
			$campos_ja_inseridos = array();
			foreach ($itens as $item) {
				$this->loadModel('Produto');
				$ret = $this->Produto->findById($item['produto_id']);
				$n = $ret['Produto']['nome'];
				$campos_ja_inseridos[$i] = array('produto_id'=>$item['produto_id']);
				$campos_ja_inseridos[$i] += array('produto_nome'=>$n);
				$campos_ja_inseridos[$i] += array('quantidade'=>$item['quantidade']);
				$campos_ja_inseridos[$i] += array('preco_venda'=>$item['preco_venda']);
				$i++;
			}
			$this->set('campos_ja_inseridos',$campos_ja_inseridos);
			return 1;
		}
		return 0;
	}
	
	function _calcular_valores($data) {
		$valor_bruto = 0;
		$valor_liquido = 0;
		foreach ($data['PedidoVendaItem'] as $c) {
			$valor_bruto += ($c['quantidade']) * ($this->Geral->moeda2numero($c['preco_venda']));
		}
		// se ha outros custos, somo para obter o valor bruto
		if (isset($data['PedidoVenda']['custo_frete']) && (! empty($data['PedidoVenda']['custo_frete']))) {
			$valor_bruto = $valor_bruto + ($this->Geral->moeda2numero($data['PedidoVenda']['custo_frete']));
		}
		if (isset($data['PedidoVenda']['custo_seguro']) && (! empty($data['PedidoVenda']['custo_seguro']))) {
			$valor_bruto = $valor_bruto + ($this->Geral->moeda2numero($data['PedidoVenda']['custo_seguro']));
		}
		if (isset($data['PedidoVenda']['custo_outros']) && (! empty($data['PedidoVenda']['custo_outros']))) {
			$valor_bruto = $valor_bruto + ($this->Geral->moeda2numero($data['PedidoVenda']['custo_outros']));
		}
		$valor_liquido = $valor_bruto;
		// se ha desconto, subtraio para obter o valor liquido
		if (isset($data['PedidoVenda']['desconto']) && (! empty($data['PedidoVenda']['desconto']))) {
			$valor_liquido = $valor_liquido - ($this->Geral->moeda2numero($data['PedidoVenda']['desconto']));
		}
		
		$retorno = array(
			'valor_bruto' => $valor_bruto,
			'valor_liquido' => $valor_liquido
		);
		
		return $retorno;
	}
	
	function cadastrar() {
		$this->set("title_for_layout","Pedido de venda"); 
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			$this->_recupera_produtos_inseridos($this->data);
			$this->loadModel('Cliente');
			$r = $this->Cliente->find('first',
				array('conditions'=>array(
					'Cliente.id' => $this->data['PedidoVenda']['cliente_id'],
					'Cliente.situacao' => 'A')));
			if (empty($r)) {
				$this->Session->setFlash('Cliente não existe ou não está ativo.','flash_erro');
				return null;
			}
			$this->data['PedidoVenda'] += array ('data_hora_cadastrado' => date('Y-m-d H:i:s'));
			$this->data['PedidoVenda'] += array ('usuario_vendeu' => $this->Auth->user('id'));
			$this->data['PedidoVenda'] += array ('usuario_cadastrou' => $this->Auth->user('id'));
			$valores = $this->_calcular_valores($this->data);
			$valor_bruto = $valores['valor_bruto'];
			$valor_liquido = $valores['valor_liquido'];
			if ($valor_liquido <= 0) {
				$this->Session->setFlash('O valor total do pedido é R$ '.$this->Geral->numero2moeda($valor_liquido),'flash_erro');
				return null;
			}
			$this->data['PedidoVenda'] += array ('valor_bruto' => $valor_bruto);
			$this->data['PedidoVenda'] += array ('valor_liquido' => $valor_liquido);
			
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->PedidoVenda->saveAll($this->data,array('validate'=>'first'))) {
				$this->Session->setFlash('Pedido de venda cadastrado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar o pedido de venda.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		$this->set("title_for_layout","Pedido de venda"); 
		$this->_obter_opcoes();
		if (empty ($this->data)) {
			$this->data = $this->PedidoVenda->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Pedido de venda não encontrado.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
			else $this->_recupera_produtos_inseridos($this->data);
		}
		else {
			$this->loadModel('Cliente');
			$r = $this->Cliente->find('first',
				array('conditions'=>array(
					'Cliente.id' => $this->data['PedidoVenda']['cliente_id'],
					'Cliente.situacao' => 'A')));
			if (empty($r)) {
				$this->Session->setFlash('Erro. Cliente não existe ou não está ativo.','flash_erro');
				return null;
			}
			//a pedido de venda pode ser editada apenas se nao tiver sido cancelada ou entregue
			$s = strtoupper($this->PedidoVenda->field('situacao'));
			if ( ($s == 'E') || ($s == 'C') ) {
				$this->Session->setFlash('A situação desta pedido de venda impede que seja editado','flash_erro');
				return false;
			}
			$this->_recupera_produtos_inseridos($this->data);
			$this->data['PedidoVenda']['id'] = $id;
			$this->data['PedidoVenda'] += array ('usuario_alterou' => $this->Auth->user('id'));
			$valores = $this->_calcular_valores($this->data);
			$valor_bruto = $valores['valor_bruto'];
			$valor_liquido = $valores['valor_liquido'];
			if ($valor_liquido <= 0) {
				$this->Session->setFlash('Erro. O valor total do pedido é R$ '.$this->Geral->numero2moeda($valor_liquido),'flash_erro');
				return null;
			}
			$this->data['PedidoVenda'] += array ('valor_bruto' => $valor_bruto);
			$this->data['PedidoVenda'] += array ('valor_liquido' => $valor_liquido);
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			// #TODO seria bom nao deletar e reinserir todos os registros
			// deleto os itens que pertenciam a pedido de venda
			if( ! ($this->PedidoVenda->Produto->deleteAll(array('produto_ordem_id'=>$id),false))) {
				$this->Session->setFlash('Erro ao salvar a pedido de venda','flash_erro');
				return false;
			}
			// insiro o que foi enviado agora, inclusive os itens
			if ($this->PedidoVenda->saveAll($this->data,array('validate'=>'first'))) {
				$s2 = $this->data['PedidoVenda']['situacao'];
				if ($s2 == 'F' || $s2 == 'E') { //se a situacao for Finalizada ou Entregue
				$fim = $this->PedidoVenda->field('data_hora_fim');
				$this->log('fim '.$fim,LOG_DEBUG);
					if (empty($fim)) {
						// se a data final nao foi preenchida
						$this->PedidoVenda->save(array('data_hora_fim'=>date('Y-m-d H:i:s')));
					}
				}
				$this->Session->setFlash('Pedido de venda atualizada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar a pedido de venda.','flash_erro');
			}
		}
	}
	
	function detalhar($id = null) {
		$this->set("title_for_layout","Pedido de venda");
		$consulta = $this->PedidoVenda->findById($id);
		if (empty($consulta)) {
			$this->Session->setFlash('Pedido de venda não encontrado','flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			// adiciono, no array resultante, o nome do produto correspondente
			$this->loadModel('Produto');
			$i = 0;
			foreach ($consulta['Produto'] as $x) {
				$nome = $this->Produto->field('nome',array('Produto.id'=>$x['produto_id']));
				$consulta['Produto'][$i]['produto_nome'] = $nome;
				$i++;
			}
			$this->set('c',$consulta);
		}
	}

	function excluir($id=NULL) {
		if (! empty($id)) {
			$this->PedidoVenda->id = $id;
			$r = $this->PedidoVenda->field('situacao');
			if (empty ($r)) {
				$this->Session->setFlash('Pedido de venda não encontrado','flash_erro');
				$this->redirect(array('action'=>'pesquisar'));
				return false;
			}
			//Uma pedido de venda apenas pode ser deletada se sua situacao for 'Orçamento' ou 'Em execução'
			$r = strtoupper($r);
			if ( ($r != 'O') && ($r != 'E') ) {
				$this->Session->setFlash('A situação da pedido de venda impede a sua exclusão. Talvez você deva apenas cancelá-la','flash_erro');
				$this->redirect(array('action'=>'index'));
				return false;
			}
			if ($this->PedidoVenda->Produto->deleteAll(array('Produto.produto_ordem_id'=>$id))) {
				if ($this->PedidoVenda->delete($id)) {
					$this->Session->setFlash("Pedido de venda número $id foi excluída com sucesso.",'flash_sucesso');
					$this->redirect(array('action'=>'index'));
				}
				else $this->Session->setFlash("Pedido de venda $id não pode ser excluído",'flassh_erro');
			}
			else $this->Session->setFlash("Pedido de venda número $id não pode ser excluído.",'flash_erro');
			$this->redirect(array('action'=>'pesquisar'));
		}
		else {
			$this->Session->setFlash('Pedido de venda não informado.','flash_erro');
			$this->redirect(array('action'=>'pesquisar'));
		}
	}
	
	function pesquisar() {
		$this->set("title_for_layout","Pedido de venda");
		$this->_obter_opcoes_pesquisa();
		if (! empty($this->data)) {
			//usuario enviou os dados da pesquisa
			$url = array('controller'=>'PedidoVendas','action'=>'pesquisar');
			//trocandos as barras dos campos de data, pois estes parametros, caso existam, vou para a url
			if (!empty($this->data['PedidoVenda']['data_hora_cadastrada'])) $this->data['PedidoVenda']['data_hora_cadastrada'] = preg_replace('/\//', '-', $this->data['PedidoVenda']['data_hora_cadastrada']);
			if (!empty($this->data['PedidoVenda']['data_hora_inicio'])) $this->data['PedidoVenda']['data_hora_inicio'] = preg_replace('/\//', '-', $this->data['PedidoVenda']['data_hora_inicio']);
			if (!empty($this->data['PedidoVenda']['data_hora_fim'])) $this->data['PedidoVenda']['data_hora_fim'] = preg_replace('/\//', '-', $this->data['PedidoVenda']['data_hora_fim']);
			// codificando os parametros
			if( is_array($this->data['PedidoVenda']) ) {
				foreach($this->data['PedidoVenda'] as &$produto) {
					$produto = urlencode($produto);
				}
			}
			$params = array_merge($url,$this->data['PedidoVenda']);
			$this->redirect($params);
		}
		
		if (! empty($this->params['named'])) {
			//a instrucao acima redirecionou para cá
			$dados = $this->params['named'];
			$condicoes=array();
			if (! empty($dados['id'])) $condicoes[] = array('PedidoVenda.id'=>$dados['id']);
			if (! empty($dados['cliente_id'])) $condicoes[] = array('PedidoVenda.cliente_id'=>$dados['cliente_id']);
			if (! empty($dados['cliente_nome'])) $condicoes[] = array('Cliente.nome LIKE'=>'%'.$dados['cliente_nome'].'%');
			if (! empty($dados['tecnico'])) $condicoes[] = array('PedidoVenda.usuario_id'=>$dados['tecnico']);
			if (! empty($dados['situacao'])) $condicoes[] = array('PedidoVenda.situacao'=>$dados['situacao']);
			if (! empty($dados['valor_total'])) $condicoes[] = array('PedidoVenda.valor_liquido'=>$dados['valor_total']);
			if (! empty($dados['usuario_cadastrou'])) $condicoes[] = array('PedidoVenda.usuario_cadastrou'=>$dados['usuario_cadastrou']);
			if (! empty($dados['data_hora_cadastrada'])) {
				$ret = explode('-', $dados['data_hora_cadastrada']);
				$dados['data_hora_cadastrada'] = $ret[2].'-'.$ret[1].'-'.$ret[0];
				// pesquiso todos os registros cadastrados entre o intervalo do dia informado pelo usuario
				$condicoes[] = array('PedidoVenda.data_hora_cadastrada BETWEEN ? AND ?'=>array($dados['data_hora_cadastrada'].' 00:00:00',$dados['data_hora_cadastrada'].' 23:59:59'));
			}
			if (! empty($dados['data_hora_inicio'])) {
				$ret = explode('-', $dados['data_hora_inicio']);
				$dados['data_hora_inicio'] = $ret[2].'-'.$ret[1].'-'.$ret[0];
				// pesquiso todos os registros cadastrados entre o intervalo do dia informado pelo usuario
				$condicoes[] = array('PedidoVenda.data_hora_inicio BETWEEN ? AND ?'=>array($dados['data_hora_inicio'].' 00:00:00',$dados['data_hora_inicio'].' 23:59:59'));
			}
			if (! empty($dados['data_hora_fim'])) {
				 $ret = explode('-', $dados['data_hora_fim']);
				$dados['data_hora_fim'] = $ret[2].'-'.$ret[1].'-'.$ret[0];
				// pesquiso todos os registros cadastrados entre o intervalo do dia informado pelo usuario
				$condicoes[] = array('PedidoVenda.data_hora_fim BETWEEN ? AND ?'=>array($dados['data_hora_fim'].' 00:00:00',$dados['data_hora_fim'].' 23:59:59'));
			}
			if (! empty ($condicoes)) {
				$resultados = $this->paginate('PedidoVenda',$condicoes);
				if (! empty($resultados)) {
					$num_encontrados = count($resultados);
					$this->set('resultados',$resultados);
					$this->set('num_resultados',$num_encontrados);
					$this->Session->setFlash("$num_encontrados pedido(s) de venda encontrados",'flash_sucesso');
				}
				else $this->Session->setFlash("Nenhum pedido de venda encontrado",'flash_erro');
			}
			else {
				$this->set('num_resultados','0');
				$this->Session->setFlash("Informe algum campo para realizar a pesquisa",'flash_erro');
			}
		}
	}
}

?>