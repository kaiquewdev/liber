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

class PedidoVendasController extends AppController {
	var $name = 'PedidoVendas';
	var $components = array('Sanitizacao','RequestHandler');
	var $helpers = array('Estados','Ajax', 'Javascript','Formatacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'PedidoVenda.id' => 'desc'
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
		$dados = $this->paginate('PedidoVenda');
		$this->set('consulta',$dados);
	}
	
	/**
	* caso algum item seja enviado (erro na validacao, editando registro, etc),
	* o insiro na pagina
	*/
	function _recupera_servicos_inseridos() {
		if ($this->data['PedidoVendaItem']) {
			$itens = $this->data['PedidoVendaItem'];
			$i = 0;
			$valor_total = 0;
			$campos_ja_inseridos = array();
			foreach ($itens as $item) {
				$this->loadModel('Produto');
				$ret = $this->Produto->findById($item['servico_id']);
				$n = $ret['Produto']['nome'];
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
	
	function _calcula_valor_total($data) {
		$valor_total = 0;
		foreach ($data['PedidoVendaItem'] as $c) {
			$valor_total += ($c['quantidade']) * ( preg_replace('/,/', '.', $c['valor']) );
		}
		return $valor_total;
	}
	
	function cadastrar() {
		$this->set("title_for_layout","Ordem de serviço"); 
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			$this->_recupera_servicos_inseridos();
			$this->loadModel('Cliente');
			$r = $this->Cliente->find('first',
				array('conditions'=>array(
					'Cliente.id' => $this->data['PedidoVenda']['cliente_id'],
					'Cliente.situacao' => 'A')));
			if (empty($r)) {
				$this->Session->setFlash('Erro. Cliente não existe ou não está ativo.','flash_erro');
				return null;
			}
			$this->data['PedidoVenda'] += array ('data_hora_cadastrada' => date('Y-m-d H:i:s'));
			$this->data['PedidoVenda'] += array ('usuario_cadastrou' => $this->Auth->user('id'));
			$valor_total = $this->_calcula_valor_total($this->data);
			$this->data['PedidoVenda'] += array ('valor_total' => $valor_total);
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->PedidoVenda->saveAll($this->data,array('validate'=>'first'))) {
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
			$this->data = $this->PedidoVenda->read();
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
					'Cliente.id' => $this->data['PedidoVenda']['cliente_id'],
					'Cliente.situacao' => 'A')));
			if (empty($r)) {
				$this->Session->setFlash('Erro. Cliente não existe ou não está ativo.','flash_erro');
				return null;
			}
			//a ordem de serviço pode ser editada apenas se nao tiver sido cancelada ou entregue
			$s = strtoupper($this->PedidoVenda->field('situacao'));
			if ( ($s == 'E') || ($s == 'C') ) {
				$this->Session->setFlash('A situação desta ordem de serviço impede que seja editada','flash_erro');
				return false;
			}
			$this->_recupera_servicos_inseridos();
			$this->data['PedidoVenda']['id'] = $id;
			$this->data['PedidoVenda'] += array ('usuario_alterou' => $this->Auth->user('id'));
			$valor_total = $this->_calcula_valor_total($this->data);
			$this->data['PedidoVenda'] += array ('valor_total' => $valor_total);
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->PedidoVenda->save($this->data)) {
				if ($s == 'F' || $s == 'E') { //se a situacao for Finalizada ou Entregue
				$fim = $this->PedidoVenda->field('data_hora_fim');
					if (empty($fim)) {
						// se a data final nao foi preenchida
						$this->PedidoVenda->save(array('data_hora_fim'=>date('Y-m-d H:i:s')));
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
		$consulta = $this->PedidoVenda->findById($id);
		if (empty($consulta)) {
			$this->Session->setFlash('Ordem de serviço não encontrada','flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			// adiciono, no array resultante, o nome do servico correspondente
			$this->loadModel('Produto');
			$i = 0;
			foreach ($consulta['PedidoVendaItem'] as $x) {
				$nome = $this->Produto->field('nome',array('Produto.id'=>$x['servico_id']));
				$consulta['PedidoVendaItem'][$i]['servico_nome'] = $nome;
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
			if ($this->PedidoVenda->PedidoVendaItem->deleteAll(array('PedidoVendaItem.servico_ordem_id'=>$id))) {
				if ($this->PedidoVenda->delete($id)) {
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
			$url = array('controller'=>'PedidoVendas','action'=>'pesquisar');
			//trocandos as barras dos campos de data, pois estes parametros, caso existam, vou para a url
			if (!empty($this->data['PedidoVenda']['data_hora_cadastrada'])) $this->data['PedidoVenda']['data_hora_cadastrada'] = preg_replace('/\//', '-', $this->data['PedidoVenda']['data_hora_cadastrada']);
			if (!empty($this->data['PedidoVenda']['data_hora_inicio'])) $this->data['PedidoVenda']['data_hora_inicio'] = preg_replace('/\//', '-', $this->data['PedidoVenda']['data_hora_inicio']);
			if (!empty($this->data['PedidoVenda']['data_hora_fim'])) $this->data['PedidoVenda']['data_hora_fim'] = preg_replace('/\//', '-', $this->data['PedidoVenda']['data_hora_fim']);
			// codificando os parametros
			if( is_array($this->data['PedidoVenda']) ) {
				foreach($this->data['PedidoVenda'] as &$servico_ordem) {
					$servico_ordem = urlencode($servico_ordem);
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
			if (! empty($dados['valor_total'])) $condicoes[] = array('PedidoVenda.valor_total'=>$dados['valor_total']);
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
	
	function pesquisaAjaxProduto($campo_a_pesquisar,$termo = null) {
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
			$this->loadModel('Produto');
			if ($campo == 'id') {
				$condicoes = array('Produto.id'=>$termo);
			}
			else {
				$condicoes = array("Produto.$campo LIKE" => '%'.$termo.'%');
			}
			$resultados = $this->Produto->find('all',array('fields' => array('id','nome','valor'),'conditions'=>$condicoes));
			if (!empty($resultados)) {
				foreach ($resultados as $r) {
					$retorno[$i]['label'] = $r['Produto']['nome'];
					$retorno[$i]['value'] = $r['Produto'][$campo];
					$retorno[$i]['id'] = $r['Produto']['id'];
					$retorno[$i]['valor'] = $r['Produto']['valor'];
					$i++; 
				}
				print json_encode($retorno);
			}
		}
	}
}

?>