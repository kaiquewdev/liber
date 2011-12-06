<?php
/**
 * A ordem de serviço tem as seguintes situações:
 * O = Orçamento
 * E = Em espera
 * X = Em execução
 * F = Finalizada
 * E = Entregue
 * C = Cancelada
 */

class ServicoOrdensController extends AppController {
	var $name = 'ServicoOrdens';
	var $components = array('Sanitizacao','RequestHandler','Geral');
	var $helpers = array('CakePtbr.Estados','Ajax', 'Javascript','CakePtbr.Formatacao', 'Geral');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'ServicoOrdem.id' => 'desc'
		)
	);
	
	var $opcoes_tecnico = array(''=>'');
	var $opcoes_forma_pamamento = array(''=>'');
	var $opcoes_usuarios = array(''=>'');
	
	/**
	 * Obtem dados do banco e popula as variaveis globais
	 * $opcoes_tecnico
	 * $opcoes_forma_pamamento
	 */
	function _obter_opcoes() {
		$this->loadModel('Usuario');
		$consulta1 = $this->Usuario->find('all',array('fields'=>array('Usuario.id','Usuario.nome'),
		'conditions'=>array('Usuario.eh_tecnico'=>'1','Usuario.ativo'=>'1')));
		foreach ($consulta1 as $op)
			$this->opcoes_tecnico += array($op['Usuario']['id']=>$op['Usuario']['nome']);
		$this->set('opcoes_tecnico',$this->opcoes_tecnico);
		
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
		$dados = $this->paginate('ServicoOrdem');
		$this->set('consulta',$dados);
	}
	
	/**
	* caso algum item seja enviado (erro na validacao, editando registro, etc),
	* o insiro na pagina
	*/
	function _recupera_servicos_inseridos() {
		if ($this->data['ServicoOrdemItem']) {
			$itens = $this->data['ServicoOrdemItem'];
			$i = 0;
			$valor_total = 0;
			$campos_ja_inseridos = array();
			foreach ($itens as $item) {
				$this->loadModel('Servico');
				$ret = $this->Servico->findById($item['servico_id']);
				$n = $ret['Servico']['nome'];
				$campos_ja_inseridos[$i] = array('servico_id'=>$item['servico_id']);
				$campos_ja_inseridos[$i] += array('servico_nome'=>$n);
				$campos_ja_inseridos[$i] += array('quantidade'=>$item['quantidade']);
				$campos_ja_inseridos[$i] += array('valor'=>$item['valor']);
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
		foreach ($data['ServicoOrdemItem'] as $c) {
			$valor_bruto += ($c['quantidade']) * ($this->Geral->moeda2numero($c['valor']));
		}
		// se ha outros custos, somo para obter o valor bruto
		if (isset($data['ServicoOrdem']['custo_outros']) && (! empty($data['ServicoOrdem']['custo_outros']))) {
			$valor_bruto = $valor_bruto + ($this->Geral->moeda2numero($data['ServicoOrdem']['custo_outros']));
		}
		$valor_liquido = $valor_bruto;
		// se ha desconto, subtraio para obter o valor liquido
		if (isset($data['ServicoOrdem']['desconto']) && (! empty($data['ServicoOrdem']['desconto']))) {
			$valor_liquido = $valor_liquido - ($this->Geral->moeda2numero($data['ServicoOrdem']['desconto']));
		}
		
		$retorno = array(
			'valor_bruto' => $valor_bruto,
			'valor_liquido' => $valor_liquido
		);
		
		return $retorno;
	}
	
	function cadastrar() {
		$this->set("title_for_layout","Ordem de serviço"); 
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			$this->_recupera_servicos_inseridos();
			$this->loadModel('Cliente');
			$r = $this->Cliente->find('first',
				array('conditions'=>array(
					'Cliente.id' => $this->data['ServicoOrdem']['cliente_id'],
					'Cliente.situacao' => 'A')));
			if (empty($r)) {
				$this->Session->setFlash('Erro. Cliente não existe ou não está ativo.','flash_erro');
				return null;
			}
			$this->data['ServicoOrdem'] += array ('data_hora_cadastrada' => date('Y-m-d H:i:s'));
			$this->data['ServicoOrdem'] += array ('usuario_cadastrou' => $this->Auth->user('id'));
			$valores = $this->_calcular_valores($this->data);
			$valor_bruto = $valores['valor_bruto'];
			$valor_liquido = $valores['valor_liquido'];
			if ($valor_liquido <= 0) {
				$this->Session->setFlash('O valor total da ordem de serviço é R$ '.$this->Geral->numero2moeda($valor_liquido),'flash_erro');
				return null;
			}
			$this->data['ServicoOrdem'] += array ('valor_bruto' => $valor_bruto);
			$this->data['ServicoOrdem'] += array ('valor_liquido' => $valor_liquido);
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
		$this->set("title_for_layout","Ordem de serviço"); 
		$this->_obter_opcoes();
		if (empty ($this->data)) {
			$this->data = $this->ServicoOrdem->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Ordem de serviço não encontrada.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
			else $this->_recupera_servicos_inseridos();
		}
		else {
			$this->loadModel('Cliente');
			$r = $this->Cliente->find('first',
				array('conditions'=>array(
					'Cliente.id' => $this->data['ServicoOrdem']['cliente_id'],
					'Cliente.situacao' => 'A')));
			if (empty($r)) {
				$this->Session->setFlash('Erro. Cliente não existe ou não está ativo.','flash_erro');
				return null;
			}
			//a ordem de serviço pode ser editada apenas se nao tiver sido cancelada ou entregue
			$s = strtoupper($this->ServicoOrdem->field('situacao'));
			if ( ($s == 'E') || ($s == 'C') ) {
				$this->Session->setFlash('A situação desta ordem de serviço impede que seja editada','flash_erro');
				return false;
			}
			$this->_recupera_servicos_inseridos();
			$this->data['ServicoOrdem']['id'] = $id;
			$this->data['ServicoOrdem'] += array ('usuario_alterou' => $this->Auth->user('id'));
			$valores = $this->_calcular_valores($this->data);
			$valor_bruto = $valores['valor_bruto'];
			$valor_liquido = $valores['valor_liquido'];
			if ($valor_liquido <= 0) {
				$this->Session->setFlash('O valor total da ordem de serviço é R$ '.$this->Geral->numero2moeda($valor_liquido),'flash_erro');
				return null;
			}
			$this->data['ServicoOrdem'] += array ('valor_bruto' => $valor_bruto);
			$this->data['ServicoOrdem'] += array ('valor_liquido' => $valor_liquido);
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			// #TODO seria bom nao deletar e reinserir todos os registros
			// deleto os itens que pertenciam a ordem de serviço
			if( ! ($this->ServicoOrdem->ServicoOrdemItem->deleteAll(array('servico_ordem_id'=>$id),false))) {
				$this->Session->setFlash('Erro ao salvar a ordem de serviço','flash_erro');
				return false;
			}
			// insiro o que foi enviado agora, inclusive os itens
			if ($this->ServicoOrdem->saveAll($this->data,array('validate'=>'first'))) {
				$s2 = $this->data['ServicoOrdem']['situacao'];
				if ($s2 == 'F' || $s2 == 'E') { //se a situacao for Finalizada ou Entregue
				$fim = $this->ServicoOrdem->field('data_hora_fim');
				$this->log('fim '.$fim,LOG_DEBUG);
					if (empty($fim)) {
						// se a data final nao foi preenchida
						$this->ServicoOrdem->save(array('data_hora_fim'=>date('Y-m-d H:i:s')));
					}
				}
				$this->Session->setFlash('Ordem de serviço atualizada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar a ordem de serviço.','flash_erro');
			}
		}
	}
	
	function detalhar($id = null) {
		$this->set("title_for_layout","Ordem de serviço");
		$consulta = $this->ServicoOrdem->findById($id);
		if (empty($consulta)) {
			$this->Session->setFlash('Ordem de serviço não encontrada','flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			// adiciono, no array resultante, o nome do servico correspondente
			$this->loadModel('Servico');
			$i = 0;
			foreach ($consulta['ServicoOrdemItem'] as $x) {
				$nome = $this->Servico->field('nome',array('Servico.id'=>$x['servico_id']));
				$consulta['ServicoOrdemItem'][$i]['servico_nome'] = $nome;
				$i++;
			}
			$this->set('c',$consulta);
		}
	}

	function excluir($id=NULL) {
		if (! empty($id)) {
			$this->ServicoOrdem->id = $id;
			$r = $this->ServicoOrdem->field('situacao');
			if (empty ($r)) {
				$this->Session->setFlash('Ordem de serviço não encontrada','flash_erro');
				$this->redirect(array('action'=>'pesquisar'));
				return false;
			}
			//Uma ordem de serviço apenas pode ser deletada se sua situacao for 'Orçamento' ou 'Em execução'
			$r = strtoupper($r);
			if ( ($r != 'O') && ($r != 'E') ) {
				$this->Session->setFlash('A situação da ordem de serviço impede a sua exclusão. Talvez você deva apenas cancelá-la','flash_erro');
				$this->redirect(array('action'=>'index'));
				return false;
			}
			if ($this->ServicoOrdem->ServicoOrdemItem->deleteAll(array('ServicoOrdemItem.servico_ordem_id'=>$id))) {
				if ($this->ServicoOrdem->delete($id)) {
					$this->Session->setFlash("Ordem de serviço número $id foi excluída com sucesso.",'flash_sucesso');
					$this->redirect(array('action'=>'index'));
				}
				else $this->Session->setFlash("Ordem de serviço $id não pode ser excluída",'flassh_erro');
			}
			else $this->Session->setFlash("Ordem de serviço número $id não pode ser excluída.",'flash_erro');
			$this->redirect(array('action'=>'pesquisar'));
		}
		else {
			$this->Session->setFlash('Ordem de serviço não informada.','flash_erro');
			$this->redirect(array('action'=>'pesquisar'));
		}
	}
	
	function pesquisar() {
		$this->set("title_for_layout","Ordem de serviço");
		$this->_obter_opcoes_pesquisa();
		if (! empty($this->data)) {
			//usuario enviou os dados da pesquisa
			$url = array('controller'=>'ServicoOrdens','action'=>'pesquisar');
			//trocandos as barras dos campos de data, pois estes parametros, caso existam, vou para a url
			if (!empty($this->data['ServicoOrdem']['data_hora_cadastrada'])) $this->data['ServicoOrdem']['data_hora_cadastrada'] = preg_replace('/\//', '-', $this->data['ServicoOrdem']['data_hora_cadastrada']);
			if (!empty($this->data['ServicoOrdem']['data_hora_inicio'])) $this->data['ServicoOrdem']['data_hora_inicio'] = preg_replace('/\//', '-', $this->data['ServicoOrdem']['data_hora_inicio']);
			if (!empty($this->data['ServicoOrdem']['data_hora_fim'])) $this->data['ServicoOrdem']['data_hora_fim'] = preg_replace('/\//', '-', $this->data['ServicoOrdem']['data_hora_fim']);
			// codificando os parametros
			if( is_array($this->data['ServicoOrdem']) ) {
				foreach($this->data['ServicoOrdem'] as &$servico_ordem) {
					$servico_ordem = urlencode($servico_ordem);
				}
			}
			$params = array_merge($url,$this->data['ServicoOrdem']);
			$this->redirect($params);
		}
		
		if (! empty($this->params['named'])) {
			//a instrucao acima redirecionou para cá
			$dados = $this->params['named'];
			$condicoes=array();
			if (! empty($dados['id'])) $condicoes[] = array('ServicoOrdem.id'=>$dados['id']);
			if (! empty($dados['cliente_id'])) $condicoes[] = array('ServicoOrdem.cliente_id'=>$dados['cliente_id']);
			if (! empty($dados['cliente_nome'])) $condicoes[] = array('Cliente.nome LIKE'=>'%'.$dados['cliente_nome'].'%');
			if (! empty($dados['tecnico'])) $condicoes[] = array('ServicoOrdem.usuario_id'=>$dados['tecnico']);
			if (! empty($dados['situacao'])) $condicoes[] = array('ServicoOrdem.situacao'=>$dados['situacao']);
			if (! empty($dados['valor_total'])) $condicoes[] = array('ServicoOrdem.valor_total'=>$dados['valor_total']);
			if (! empty($dados['usuario_cadastrou'])) $condicoes[] = array('ServicoOrdem.usuario_cadastrou'=>$dados['usuario_cadastrou']);
			if (! empty($dados['data_hora_cadastrada'])) {
				$ret = explode('-', $dados['data_hora_cadastrada']);
				$dados['data_hora_cadastrada'] = $ret[2].'-'.$ret[1].'-'.$ret[0];
				// pesquiso todos os registros cadastrados entre o intervalo do dia informado pelo usuario
				$condicoes[] = array('ServicoOrdem.data_hora_cadastrada BETWEEN ? AND ?'=>array($dados['data_hora_cadastrada'].' 00:00:00',$dados['data_hora_cadastrada'].' 23:59:59'));
			}
			if (! empty($dados['data_hora_inicio'])) {
				$ret = explode('-', $dados['data_hora_inicio']);
				$dados['data_hora_inicio'] = $ret[2].'-'.$ret[1].'-'.$ret[0];
				// pesquiso todos os registros cadastrados entre o intervalo do dia informado pelo usuario
				$condicoes[] = array('ServicoOrdem.data_hora_inicio BETWEEN ? AND ?'=>array($dados['data_hora_inicio'].' 00:00:00',$dados['data_hora_inicio'].' 23:59:59'));
			}
			if (! empty($dados['data_hora_fim'])) {
				 $ret = explode('-', $dados['data_hora_fim']);
				$dados['data_hora_fim'] = $ret[2].'-'.$ret[1].'-'.$ret[0];
				// pesquiso todos os registros cadastrados entre o intervalo do dia informado pelo usuario
				$condicoes[] = array('ServicoOrdem.data_hora_fim BETWEEN ? AND ?'=>array($dados['data_hora_fim'].' 00:00:00',$dados['data_hora_fim'].' 23:59:59'));
			}
			if (! empty ($condicoes)) {
				$resultados = $this->paginate('ServicoOrdem',$condicoes);
				if (! empty($resultados)) {
					$num_encontrados = count($resultados);
					$this->set('resultados',$resultados);
					$this->set('num_resultados',$num_encontrados);
					$this->Session->setFlash("$num_encontrados ordem(ns) de serviço(s) encontradas",'flash_sucesso');
				}
				else $this->Session->setFlash("Nenhuma ordem de serviço encontrada",'flash_erro');
			}
			else {
				$this->set('num_resultados','0');
				$this->Session->setFlash("Informe algum campo para realizar a pesquisa",'flash_erro');
			}
		}
	}
	
	
}

?>