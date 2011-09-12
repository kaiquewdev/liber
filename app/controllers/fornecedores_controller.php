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
	var $opcoes_categoria_fornecedor = array();
	var $opcoes_empresa = array();
	
	/**
	 * Obtem dados do banco e popula as variaveis globais
	 * $opcoes_categoria_fornecedor
	 * $opcoes_empresa
	 */
	function _obter_opcoes() {
		$this->loadModel('FornecedorCategoria');
		$consulta1 = $this->FornecedorCategoria->find('all',array('fields'=>array('FornecedorCategoria.id','FornecedorCategoria.descricao')));
		foreach ($consulta1 as $op)
			$this->opcoes_categoria_fornecedor += array($op['FornecedorCategoria']['id']=>$op['FornecedorCategoria']['descricao']);
		$this->set('opcoes_categoria_fornecedor',$this->opcoes_categoria_fornecedor);
		
		$this->loadModel('Empresa');
		$consulta2 = $this->Empresa->find('all');
		foreach ($consulta2 as $op)
			$this->opcoes_empresa += array($op['Empresa']['id']=>$op['Empresa']['nome']);
		$this->set('opcoes_empresa',$this->opcoes_empresa);
		return null;
	}
	
	
	/**
	 * Lista todos os Fornecedores
	 */
	function index() {
		$dados = $this->paginate('Fornecedor');
		$this->set('consulta_fornecedor',$dados);
	}
	
	function cadastrar() {
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			$this->data['Fornecedor'] += array ('data_cadastrado' => date('Y-m-d H:i:s'));
			$this->data['Fornecedor'] += array ('usuario_cadastrou' => $this->Auth->user('id'));
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
	
	function editar($id=NULL) {
		$this->_obter_opcoes();
		if (empty ($this->data)) {
			$this->data = $this->Fornecedor->read();
			if ( ! $this->data) {
				$this->Session->setFlash('Fornecedor não encontrado.');
				$this->redirect(array('controller'=>'Fornecedores','action'=>'cadastrar'));
			}
		}
		else {
			$this->data['Fornecedor']['id'] = $id;
			$this->data['Fornecedor'] += array ('atualizado' => date('Y-m-d H:i:s'));
			$this->data['Fornecedor'] += array ('usuario_alterou' => $this->Auth->user('id'));
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
	
	function pesquisar() {
		
		if (! empty($this->data)) {
			//usuario enviou os dados da pesquisa
			$url = array('controller'=>'Fornecedores','action'=>'pesquisar');
			$params = array_merge($url,$this->data['Fornecedor']);
			$this->redirect($params);
		}
		
		if (! empty($this->params['named'])) {
			//a instrucao acima redirecionou para cá
			$dados = $this->params['named'];
			$condicoes=array();
			if (! empty($dados['nome'])) $condicoes[] = array('Fornecedor.nome LIKE'=>'%'.$dados['nome'].'%');
			if (! empty($dados['nome_fantasia'])) $condicoes[] = array('Fornecedor.nome_fantasia LIKE'=>'%'.$dados['nome_fantasia'].'%');
			if (! empty($dados['bairro'])) $condicoes[] = array('Fornecedor.bairro'=>$dados['bairro']);
			if (! empty($dados['cidade'])) $condicoes[] = array('Fornecedor.cidade'=>$dados['cidade']);
			if (! empty($dados['cnpj'])) $condicoes[] = array('Fornecedor.cnpj'=>$dados['cnpj']);
			if (! empty($dados['inscricao_estadual'])) $condicoes[] = array('Fornecedor.inscricao_estadual'=>$dados['inscricao_estadual']);
			if (! empty($dados['cpf'])) $condicoes[] = array('Fornecedor.cpf'=>$dados['cpf']);
			if (! empty($dados['rg'])) $condicoes[] = array('Fornecedor.rg'=>$dados['rg']);
			if (! empty ($condicoes)) {
				$resultados = $this->paginate('Fornecedor',$condicoes);
				if (! empty($resultados)) {
					$num_encontrados = count($resultados);
					$this->set('resultados',$resultados);
					$this->set('num_resultados',$num_encontrados);
					$this->Session->setFlash("$num_encontrados Fornecedor(s) encontrado(s)");
				}
				else $this->Session->setFlash("Nenhum fornecedor encontrado");
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
			$this->set('fornecedor',$this->Fornecedor->read());
		}
		else {
			$this->Session->setFlash('Erro: nenhum Fornecedor informado.');
		}
	}
	
}

?>