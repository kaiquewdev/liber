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
	
	
	/**
	 * Lista todos os Clientes
	 */
	function index() {
		$dados = $this->paginate('Cliente');
		$this->set('consulta_cliente',$dados);
	}
	
	function cadastrar() {
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			$this->data['Cliente'] += array ('data_cadastrado' => date('Y-m-d H:i:s'));
			$this->data['Cliente'] += array ('usuario_cadastrou' => $this->Auth->user('id'));
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->Cliente->save($this->data)) {
				$this->Session->setFlash('Cliente cadastrado com sucesso.','flash_sucesso');
				$this->redirect(array('controller'=>'Clientes'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar o cliente.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		$this->_obter_opcoes();
		if (empty ($this->data)) {
			$this->data = $this->Cliente->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Cliente não encontrado.','flash_erro');
				$this->redirect(array('controller'=>'Clientes','action'=>'pesquisar'));
			}
		}
		else {
			$this->data['Cliente']['id'] = $id;
			$this->data['Cliente'] += array ('atualizado' => date('Y-m-d H:i:s'));
			$this->data['Cliente'] += array ('usuario_alterou' => $this->Auth->user('id'));
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->Cliente->save($this->data)) {
				$this->Session->setFlash('Cliente atualizado com sucesso.','flash_sucesso');
				$this->redirect(array('controller'=>'Clientes'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar o cliente.','flash_erro');
			}
		}
	}
	
	function pesquisar() {
		
		if (! empty($this->data)) {
			//usuario enviou os dados da pesquisa
			$url = array('controller'=>'Clientes','action'=>'pesquisar');
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
	
	function detalhar($id = NULL) {
		if ($id) {
			$this->Cliente->id = $id;
			$this->set('cliente',$this->Cliente->read());
		}
		else {
			$this->Session->setFlash('Erro: nenhum cliente informado.','flash_erro');
		}
	}
	
}

?>