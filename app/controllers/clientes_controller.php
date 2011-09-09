<?php

class ClientesController extends AppController {
	var $name = 'Clientes'; // PHP 4
	var $helpers = array('Estados','Javascript');
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Cliente.id' => 'asc'
		)
	);
	var $opcoes_categoria_cliente = array();
	var $opcoes_empresa = array();
	
	/**
	 * Obtem dados do banco e popula as variaveis globais
	 * $opcoes_categoria_cliente
	 * $opcoes_empresa
	 */
	function _obter_opcoes() {
		$this->loadModel('ClienteCategoria');
		$consulta1 = $this->ClienteCategoria->find('all',array('fields'=>array('ClienteCategoria.id','ClienteCategoria.descricao')));
		foreach ($consulta1 as $op)
			$this->opcoes_categoria_cliente += array($op['ClienteCategoria']['id']=>$op['ClienteCategoria']['descricao']);
		$this->set('opcoes_categoria_cliente',$this->opcoes_categoria_cliente);
		
		$this->loadModel('Empresa');
		$consulta2 = $this->Empresa->find('all');
		foreach ($consulta2 as $op)
			$this->opcoes_empresa += array($op['Empresa']['id']=>$op['Empresa']['nome']);
		$this->set('opcoes_empresa',$this->opcoes_empresa);
		return null;
	}
	
	function index() {
		$dados = $this->paginate('Cliente');
		$this->set('consulta_cliente',$dados);
	}
	
	function cadastrar($id = null) {
		$this->_obter_opcoes();
		if (empty ($id)) { //cadastrando cliente
			$this->set('acao','adicionar');
			if (! empty($this->data)) {
				$this->data['Cliente'] += array ('data_cadastrado' => date('Y-m-d H:i:s'));
				$this->data['Cliente'] += array ('usuario_cadastrou' => $this->Auth->user('id'));
				$this->data = $this->Sanitizacao->sanitizar($this->data);
				if ($this->Cliente->save($this->data)) {
					$this->Session->setFlash('Cliente cadastrado com sucesso.');
					$this->redirect(array('controller'=>'clientes'));
				}
				else {
					$this->Session->setFlash('Erro ao cadastrar o cliente.');
				}
			}
		}
		else { //atualizando cliente
			$this->set('acao','editar');
			$this->Cliente->id = $id;
			if (empty ($this->data)) {
				$this->data = $this->Cliente->read();
				if ( ! $this->data) {
					$this->Session->setFlash('Cliente não encontrado.');
					$this->redirect(array('controller'=>'clientes','action'=>'cadastrar'));
				}
			}
			else {
				$this->data['Cliente'] += array ('atualizado' => date('Y-m-d H:i:s'));
				$this->data['Cliente'] += array ('usuario_alterou' => $this->Auth->user('id'));
				$this->data = $this->Sanitizacao->sanitizar($this->data);
				if ($this->Cliente->save($this->data)) {
					$this->Session->setFlash('Cliente atualizado com sucesso.');
					$this->redirect(array('controller'=>'clientes'));
				}
				else {
					$this->Session->setFlash('Erro ao atualizar o cliente.');
				}
			}
		}
	}
	
	function pesquisar() {
		
		if (! empty($this->data)) {
			//usuario enviou os dados da pesquisa
			$url = array('controller'=>'clientes','action'=>'pesquisar');
			/**
			 * #XXX Quê isso faz?!
			 * http://blog.bonetree.net/2010/03/cakephp-paginator-urls-and-post-forms/
			 */
			if (is_array($this->data['Cliente'])) {
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
			if (! empty($dados['nome'])) $condicoes[] = array('nome LIKE'=>'%'.$dados['nome'].'%');
			if (! empty($dados['nome_fantasia'])) $condicoes[] = array('nome_fantasia LIKE'=>'%'.$dados['nome_fantasia'].'%');
			if (! empty($dados['bairro'])) $condicoes[] = array('bairro'=>$dados['bairro']);
			if (! empty($dados['cidade'])) $condicoes[] = array('cidade'=>$dados['cidade']);
			if (! empty($dados['cnpj'])) $condicoes[] = array('cnpj'=>$dados['cnpj']);
			if (! empty($dados['inscricao_estadual'])) $condicoes[] = array('inscricao_estadual'=>$dados['inscricao_estadual']);
			if (! empty($dados['cpf'])) $condicoes[] = array('cpf'=>$dados['cpf']);
			if (! empty($dados['rg'])) $condicoes[] = array('rg'=>$dados['rg']);
			if (! empty ($condicoes)) {
				//$resultados = $this->Cliente->find('all',array('conditions'=>$condicoes));
				$resultados = $this->paginate('Cliente',$condicoes);
				if (! empty($resultados)) {
					$num_encontrados = count($resultados);
					$this->set('resultados',$resultados);
					$this->set('num_resultados',$num_encontrados);
					$this->Session->setFlash("$num_encontrados cliente(s) encontrado(s)");
				}
			}
			else {
				$this->set('num_resultados','0');
				$this->Session->setFlash("Nenhum resultado encontrado");
			}
		}
	}
	
	function detalhar($id = NULL) {
		if ($id) {
			$this->Cliente->id = $id;
			$this->set('cliente',$this->Cliente->read());
		}
		else {
			$this->Session->setFlash('Erro: nenhum cliente informado.');
		}
	}
	
}

?>