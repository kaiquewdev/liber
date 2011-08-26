<?php

class ClientesController extends AppController {
	var $name = 'Clientes'; // PHP 4
	var $helpers = array('Estados','Ajax', 'Javascript');
	var $components = array('Sanitizacao','RequestHandler');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Cliente.id' => 'asc'
		)
	);
	
	/**
	 * Lista todos os clientes
	 */
	function index() {
		$dados = $this->paginate('Cliente');
		$this->set('consulta_cliente',$dados);
	}
	
	function cadastrar($id = null) {
		if (empty ($id)) { //cadastrando cliente
			$this->set('acao','adicionar');
			if (! empty($this->data)) {
				$this->data['Cliente'] += array ('data_cadastrado' => date('Y-m-d H:i:s'));
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
	
	function pesquisaAjax($campo_a_pesquisar,$termo = null) {
		if ($campo_a_pesquisar == 'nome') $campo = 'nome';
		if (! isset($termo)) $termo = $this->params['url']['term'];
		
		if ( $this->RequestHandler->isAjax() ) {
   			Configure::write ( 'debug', 0 );
   			$this->autoRender=false;
			$resultados = $this->Cliente->find('all',
			array(
			'fields' => array('id',$campo),
			'conditions' => array($campo.' LIKE' => '%'.$termo.'%')
			));
			$i=0;
			$retorno=array();
			$r = array();
			foreach ($resultados as $r) {
				$retorno[$i]['label'] = $r['Cliente'][$campo];
				$retorno[$i]['value'] = $r['Cliente']['id'];
				$i++; 
			}
			print json_encode($retorno);
		}
	}
	
	function pesquisar() {
		if (! empty($this->data)) {
			$dados = $this->data['Cliente'];
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