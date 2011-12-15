<?php
/**
 * O pedido de venda tem as seguintes situações:
 * A = Aberto
 * O = Orçamento
 * C = Cancelado
 * V = Vendido
 */

//#TODO criar alerta caso o(s) pedido(s) totalize(m) um valor maior que o limite de credito  
//FIXME utilizar transaction
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
	
	function _obter_opcoes() {
		$opcoes_forma_pamamento = $this->PedidoVenda->FormaPagamento->find('list',array('fields'=>array('FormaPagamento.id','FormaPagamento.nome')));
		$this->set('opcoes_forma_pamamento',$opcoes_forma_pamamento);
		
		$opcoes_empresas = $this->PedidoVenda->Empresa->find('list',array('fields'=>array('Empresa.id','Empresa.nome')));
		$this->set('opcoes_empresas',$opcoes_empresas);
		
		$opcoes_situacoes = array(
			'A'=>'Aberto',
			'O' => 'Orçamento',
			'C' => 'Cancelado',
			'V' => 'Vendido',
		);
		$this->set('opcoes_situacoes',$opcoes_situacoes);
		
		// view pesquisa
		$this->loadModel('Usuario');	
		$opcoes_usuarios = $this->Usuario->find('list',array('fields'=>array('Usuario.id','Usuario.nome'), 'conditions'=>array('Usuario.ativo'=>'1','Usuario.eh_tecnico'=>'0')));
		$this->set('opcoes_usuarios',$opcoes_usuarios);
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
				$n = $this->PedidoVenda->PedidoVendaItem->Produto->findById($item['produto_id']);
				$n = $n['Produto']['nome'];
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
			$valor_liquido = $valor_bruto - ($this->Geral->moeda2numero($data['PedidoVenda']['desconto']));
		}
		
		$retorno = array(
			'valor_bruto' => $valor_bruto,
			'valor_liquido' => $valor_liquido
		);
		
		return $retorno;
	}
	
	/**
	 * Gera conta a receber
	 * Executar depois de se ter os dados prontos para serem inseridos no banco
	 * 
	 * @param $valor_total da conta a receber
	 * @param $opcoes (array)
	 * @param $opcoes['numero_parcelas'] numero de parcelas a serem utilizadas
	 * 
	 * @return NULL
	 * @return Dados já são inseridos no banco
	 */
	function _gerar_conta_receber ($valor_total=null, $opcoes=array()) {
		if (empty($valor_total)) return false;
		
		$valor_liquido = $valor_total;
		
		// Apenas crio a forma de pagamento se a situacao do pedido for 'Vendido'
		if (strtoupper($this->data['PedidoVenda']['situacao']) == 'V' ) {
			$forma_pagamento = $this->PedidoVenda->FormaPagamento->find('all',array('conditions'=>array('FormaPagamento.id' => $this->data['PedidoVenda']['forma_pagamento_id']),'recursive'=>'-1') );
			$forma_pagamento = $forma_pagamento[0]['FormaPagamento'];

			// se a forma de pagamento for 'A vista'
			if ($forma_pagamento['numero_maximo_parcelas'] == 0) {
				if ( $forma_pagamento['porcentagem_desconto_a_vista'] > 0) {
					//aplico desconto a vista
					$valor_a_receber = $valor_liquido - (($valor_liquido * $forma_pagamento['porcentagem_desconto_a_vista'])/100);
				}
				else $valor_a_receber = $valor_liquido;
				
				$conta_receber = array(
					'ReceberConta' => array(
						'data_hora_cadastrada' => date('Y-m-d H:i:s'),
						'eh_fiscal' => 0, //#TODO mudar quando houver nota fiscal e/ou uma abrangencia fiscal maior
						'eh_cliente_ou_fornecedor' => 'C',
						'cliente_fornecedor_id' => $this->data['PedidoVenda']['cliente_id'],
						'tipo_documento_id' => $forma_pagamento['tipo_documento_id'],
						'numero_documento' => $this->PedidoVenda->id,
						'valor' => $valor_a_receber,
						'conta_origem' => $forma_pagamento['conta_principal'],
						'plano_conta_id' => '11',
						'data_vencimento' => date("Y-m-d"),
						'situacao' => 'N',
						'empresa_id' => $this->data['PedidoVenda']['empresa_id'],
					),
				);
			}
			else { // a forma de pagamento tem uma ou mais parcelas
				$numero_parcelas = $this->data['PedidoVenda']['numero_parcelas'];
				if ($numero_parcelas > $forma_pagamento['numero_maximo_parcelas']) {
					$this->Session->setFlash('Número de parcelas escolhido ultrapassa o máximo permitido!','flash_erro');
					return null;
				}

				// a forma de pagamento nao tem um valor minimo por parcela
				if ($forma_pagamento['valor_minimo_parcela'] <= 0) {
					// crio um array contendo as parcelas
					$valor_a_receber = array();
					for ($j=1;$j<=$numero_parcelas;$j++) {
						$valor_a_receber[$j] = $valor_liquido / $numero_parcelas;
						$valor_a_receber[$j] = number_format($valor_a_receber[$j],2,'.','');
					}

					// se o valor de todas as parcelas somadas for menor que o valor da compra
					// acrescento a diferença na ultima parcela
					// até este momento todos os elementos do array $valor_a_receber sao iguais
					$diferenca = ($valor_liquido - ($valor_a_receber[1]*$numero_parcelas) );
					if ( $diferenca > 0 ) {
						$valor_a_receber[$numero_parcelas-1] += $diferenca;
					}
					else if ($diferenca < 0) {
						//#TODO  o somatorio das parcelas é maior que o valor liquido. Fazer algo?
					}
				}
				else { // a forma de pagamento tem um valor mínimo para cada parcela
					// crio um array contendo as parcelas
					$valor_a_receber = array();
					for ($j=1;$j<=$numero_parcelas;$j++) {
						$valor_a_receber[$j] = $valor_liquido / $numero_parcelas;
						if ($valor_a_receber[$j] < $forma_pagamento['valor_minimo_parcela']) {
							$valor_a_receber[$j] = $forma_pagamento['valor_minimo_parcela'];
						}
						$valor_a_receber[$j] = number_format($valor_a_receber[$j],2,'.','');
					}
					// se o valor de todas as parcelas somadas for menor que o valor da compra
					// acrescento a diferença na ultima parcela
					$s = 0;
					foreach ($valor_a_receber as $v) {
						$s += $v;
					}
					$diferenca = ($valor_liquido - $s );
					if ( $diferenca > 0 ) {
						$valor_a_receber[$numero_parcelas-1] += $diferenca;
					}
					else if ($diferenca < 0) {
						// este é bem provavel que dê mais
						//#TODO  o somatorio das parcelas é maior que o valor liquido. Fazer algo?
					}

				}

				$conta_receber = array(
					'ReceberConta' => array(
						//0 => array(),
					),
				);
				// para cada parcela
				for ($i = 1; $i <= $numero_parcelas; $i++) {
					if ( ($i > $forma_pagamento['numero_parcelas_sem_juros']) && ($forma_pagamento['porcentagem_juros'] > 0) ) {
						// aplicar juros
						$juros = (($valor_a_receber[$i]*number_format($forma_pagamento['porcentagem_juros'],2,'.','')) / 100);
						$valor_a_receber[$i] += $juros;
						$valor_a_receber[$i] = number_format($valor_a_receber[$i],2,'.','');
					}

					$conta =  array(
						($i) => array(
							'data_hora_cadastrada' => date('Y-m-d H:i:s'),
							'eh_fiscal' => 0, //#TODO mudar quando houver nota fiscal e/ou uma abrangencia fiscal maior
							'eh_cliente_ou_fornecedor' => 'C',
							'cliente_fornecedor_id' => $this->data['PedidoVenda']['cliente_id'],
							'tipo_documento_id' => $forma_pagamento['tipo_documento_id'],
							'numero_documento' => $this->PedidoVenda->id,
							'valor' => $valor_a_receber[$i],
							'conta_origem' => $forma_pagamento['conta_principal'],
							'plano_conta_id' => '11',
							'data_vencimento' => date("Y-m-d",time()+3600*24*($forma_pagamento['dias_intervalo_parcelamento'])),
							'situacao' => 'N',
							'empresa_id' => $this->data['PedidoVenda']['empresa_id'],
						),
					);
					$conta_receber['ReceberConta'] = array_merge($conta_receber['ReceberConta'],$conta);
				}
			}

			$this->loadModel('ReceberConta');
			if (! ($this->ReceberConta->saveAll($conta_receber['ReceberConta']))) {
				$this->Session->setFlash('Erro ao cadastrar o pedido de venda/conta a receber.','flash_erro');
				return false;
			}
			return 1;
		} // fim conta a receber
		return 99;
	}
	
	function index() {
		$dados = $this->paginate('PedidoVenda');
		$this->set('consulta',$dados);
		$this->_obter_opcoes();
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
				if ( $this->_gerar_conta_receber($valor_liquido) === false ) {
					return false;
				}
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
			else {
				$this->_recupera_produtos_inseridos($this->data);
				
				if ($this->data['PedidoVenda']['data_saida'] == '0000-00-00') $this->data['PedidoVenda']['data_saida'] = null;
				else $this->data['PedidoVenda']['data_saida'] = date('d/m/Y', strtotime($this->data['PedidoVenda']['data_saida']));
				
				if ($this->data['PedidoVenda']['data_entrega'] == '0000-00-00') $this->data['PedidoVenda']['data_entrega'] = null;
				else $this->data['PedidoVenda']['data_entrega'] = date('d/m/Y', strtotime($this->data['PedidoVenda']['data_entrega']));
				
				if ($this->data['PedidoVenda']['data_venda'] == '0000-00-00') $this->data['PedidoVenda']['data_venda'] = null;
				else $this->data['PedidoVenda']['data_venda'] = date('d/m/Y', strtotime($this->data['PedidoVenda']['data_venda']));
			}
		}
		else {
			$this->_recupera_produtos_inseridos($this->data);
			$this->loadModel('Cliente');
			$r = $this->Cliente->find('first',
				array('conditions'=>array(
					'Cliente.id' => $this->data['PedidoVenda']['cliente_id'],
					'Cliente.situacao' => 'A')));
			if (empty($r)) {
				$this->Session->setFlash('Erro. Cliente não existe ou não está ativo.','flash_erro');
				return null;
			}
			//o pedido de venda pode ser editado apenas se nao tiver sido cancelado ou vendido
			$s = strtoupper($this->PedidoVenda->field('situacao'));
			if ( ($s == 'V') || ($s == 'C') ) {
				$this->Session->setFlash('A situação desta pedido de venda impede que seja editado','flash_erro');
				return null;
			}
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
			if( ! ($this->PedidoVenda->PedidoVendaItem->deleteAll(array('pedido_venda_id'=>$id),false))) {
				$this->Session->setFlash('Erro ao salvar a pedido de venda','flash_erro');
				return null;
			}
			// insiro o que foi enviado agora, inclusive os itens
			if ($this->PedidoVenda->saveAll($this->data,array('validate'=>'first'))) {
				if ( $this->_gerar_conta_receber($valor_liquido) === false ) {
					return false;
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
			$i = 0;
			$this->loadModel('Produto');
			foreach ($consulta['PedidoVendaItem'] as $x) {
				$nome = $this->Produto->field('nome',array('Produto.id'=>$x['produto_id']));
				$consulta['PedidoVendaItem'][$i]['produto_nome'] = $nome;
				$i++;
			}
			$this->set('c',$consulta);
			$this->_obter_opcoes();
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
			//Uma pedido de venda apenas pode ser deletado se sua situacao for 'Orçamento' ou 'Aberto'
			$r = strtoupper($r);
			if ( ($r != 'O') && ($r != 'A') ) {
				$this->Session->setFlash('A situação do pedido de venda impede a sua exclusão. Talvez você deva apenas cancelá-lo','flash_erro');
				$this->redirect(array('action'=>'index'));
				return false;
			}
			if ($this->PedidoVenda->PedidoVendaItem->deleteAll(array('PedidoVendaItem.pedido_venda_id'=>$id))) {
				if ($this->PedidoVenda->delete($id)) {
					$this->Session->setFlash("Pedido de venda número $id foi excluído com sucesso.",'flash_sucesso');
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
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			//usuario enviou os dados da pesquisa
			$url = array('controller'=>'PedidoVendas','action'=>'pesquisar');
			//trocandos as barras dos campos de data, pois estes parametros, caso existam, vou para a url
			if (!empty($this->data['PedidoVenda']['data_hora_cadastrado'])) $this->data['PedidoVenda']['data_hora_cadastrado'] = preg_replace('/\//', '-', $this->data['PedidoVenda']['data_hora_cadastrado']);
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
			if (! empty($dados['situacao'])) $condicoes[] = array('PedidoVenda.situacao'=>$dados['situacao']);
			if (! empty($dados['valor_total'])) $condicoes[] = array('PedidoVenda.valor_liquido'=>$dados['valor_total']);
			if (! empty($dados['usuario_cadastrou'])) $condicoes[] = array('PedidoVenda.usuario_cadastrou'=>$dados['usuario_cadastrou']);
			if (! empty($dados['data_hora_cadastrado'])) {
				$ret = explode('-', $dados['data_hora_cadastrado']);
				$dados['data_hora_cadastrado'] = $ret[2].'-'.$ret[1].'-'.$ret[0];
				// pesquiso todos os registros cadastrados entre o intervalo do dia informado pelo usuario
				$condicoes[] = array('PedidoVenda.data_hora_cadastrada BETWEEN ? AND ?'=>array($dados['data_hora_cadastrada'].' 00:00:00',$dados['data_hora_cadastrada'].' 23:59:59'));
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