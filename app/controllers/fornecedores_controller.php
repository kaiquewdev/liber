<?php

class FornecedoresController extends AppController {
	var $name = 'Fornecedores'; // PHP 4
	var $helpers = array('Estados','Javascript');
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Fornecedor.id' => 'asc'
		)
	);
	
	/**
	 * Lista todos os Fornecedores
	 */
	function index() {
		$dados = $this->paginate('Fornecedor');
		$this->set('consulta_Fornecedor',$dados);
	}
	
	function cadastrar($id = null) {
		if (empty ($id)) { //cadastrando Fornecedor
			$this->set('acao','adicionar');
			if (! empty($this->data)) {
				$this->data['Fornecedor'] += array ('data_cadastrado' => date('Y-m-d H:i:s'));
				$this->data = $this->Sanitizacao->sanitizar($this->data);
				if ($this->Fornecedor->save($this->data)) {
					$this->Session->setFlash('Fornecedor cadastrado com sucesso.');
					$this->redirect(array('controller'=>'Fornecedores'));
				}
				else {
					$this->Session->setFlash('Erro ao cadastrar o Fornecedor.');
				}
			}
		}
		else { //atualizando Fornecedor
			$this->set('acao','editar');
			$this->Fornecedor->id = $id;
			if (empty ($this->data)) {
				$this->data = $this->Fornecedor->read();
				if ( ! $this->data) {
					$this->Session->setFlash('Fornecedor não encontrado.');
					$this->redirect(array('controller'=>'Fornecedores','action'=>'cadastrar'));
				}
			}
			else {
				$this->data['Fornecedor'] += array ('atualizado' => date('Y-m-d H:i:s'));
				$this->data = $this->Sanitizacao->sanitizar($this->data);
				if ($this->Fornecedor->save($this->data)) {
					$this->Session->setFlash('Fornecedor atualizado com sucesso.');
					$this->redirect(array('controller'=>'Fornecedores'));
				}
				else {
					$this->Session->setFlash('Erro ao atualizar o Fornecedor.');
				}
			}
		}
	}
	
	function pesquisar() {
		
		if (! empty($this->data)) {
			//usuario enviou os dados da pesquisa
			$url = array('controller'=>'Fornecedores','action'=>'pesquisar');
			/**
			 * #XXX Quê isso faz?!
			 * http://blog.bonetree.net/2010/03/cakephp-paginator-urls-and-post-forms/
			 */
			if (is_array($this->data['Fornecedor'])) {
				foreach($this->data['Fornecedor'] as &$Fornecedor) {
					$Fornecedor = urlencode($Fornecedor);
				}
			}
			$params = array_merge($url,$this->data['Fornecedor']);
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
				//$resultados = $this->Fornecedor->find('all',array('conditions'=>$condicoes));
				$resultados = $this->paginate('Fornecedor',$condicoes);
				if (! empty($resultados)) {
					$num_encontrados = count($resultados);
					$this->set('resultados',$resultados);
					$this->set('num_resultados',$num_encontrados);
					$this->Session->setFlash("$num_encontrados Fornecedor(s) encontrado(s)");
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
			$this->Fornecedor->id = $id;
			$this->set('Fornecedor',$this->Fornecedor->read());
		}
		else {
			$this->Session->setFlash('Erro: nenhum Fornecedor informado.');
		}
	}
	
}

?>