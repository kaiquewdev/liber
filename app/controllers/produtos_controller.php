<?php

class ProdutosController extends AppController {
	var $name = 'Produtos';
	var $components = array('Sanitizacao');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Produto.id' => 'desc'
		)
	);
	var $opcoes_categoria_produto = array();
	
	/**
	 * Obtem dados do banco e popula as variaveis globais
	 * $opcoes_categoria_produto
	 */
	function _obter_opcoes() {
		$this->loadModel('CategoriaProduto');
		$consulta1 = $this->CategoriaProduto->find('all',array('fields'=>array('CategoriaProduto.id','CategoriaProduto.nome')));
		foreach ($consulta1 as $op)
			$this->opcoes_categoria_produto += array($op['CategoriaProduto']['id']=>$op['CategoriaProduto']['nome']);
		$this->set('opcoes_categoria_produto',$this->opcoes_categoria_produto);
	}
	
	function index() {
		$dados = $this->paginate('Produto');
		$this->set('consulta',$dados);
	}
	
	function cadastrar() {
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->Produto->save($this->data)) {
				$this->Session->setFlash('Produto cadastrado com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar o produto.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		$this->_obter_opcoes();
		if (empty ($this->data)) {
			$this->data = $this->Produto->read();
			if ( ! $this->data) {
				$this->Session->setFlash("Produto $id não encontrado.",'flash_erro');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->data['Produto']['id'] = $id;
			$this->data = $this->Sanitizacao->sanitizar($this->data);
			if ($this->Produto->save($this->data)) {
				$this->Session->setFlash("Produto $id atualizado com sucesso.",'flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar o produto.','flash_erro');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($this->Produto->delete($id)) $this->Session->setFlash("Produto $id excluído com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Produto $id não pode ser excluído.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Produto não informado.','flash_erro');
		}
	}

	function pesquisar() {
		$this->_obter_opcoes();
		if (! empty($this->data)) {
			//usuario enviou os dados da pesquisa
			$url = array('action'=>'pesquisar');
			$params = array_merge($url,$this->data['Produto']);
			$this->redirect($params);
		}
		
		if (! empty($this->params['named'])) {
			//a instrucao acima redirecionou para cá
			$dados = $this->params['named'];
			$condicoes=array();
			if (! empty($dados['nome'])) $condicoes[] = array('Produto.nome LIKE'=>'%'.$dados['nome'].'%');
			if (! empty($dados['categoria_produto_id'])) $condicoes[] = array('Produto.categoria_produto_id'=>$dados['categoria_produto_id']);
			if (! empty($dados['tipo_produto'])) $condicoes[] = array('Produto.tipo_produto'=>$dados['tipo_produto']);
			if (! empty($dados['codigo_ean'])) $condicoes[] = array('Produto.codigo_ean'=>$dados['codigo_ean']);
			if (! empty($dados['codigo_dun'])) $condicoes[] = array('Produto.codigo_dun'=>$dados['codigo_dun']);
			if (! empty($dados['unidade'])) $condicoes[] = array('Produto.unidade'=>$dados['unidade']);
			if (! empty($dados['quantidade_estoque_fiscal'])) $condicoes[] = array('Produto.quantidade_estoque_fiscal'=>$dados['quantidade_estoque_fiscal']);
			if (! empty($dados['situacao'])) $condicoes[] = array('Produto.situacao'=>$dados['situacao']);
			if (! empty ($condicoes)) {
				$resultados = $this->paginate('Produto',$condicoes);
				if (! empty($resultados)) {
					$num_encontrados = count($resultados);
					$this->set('resultados',$resultados);
					$this->set('num_resultados',$num_encontrados);
					$this->Session->setFlash("$num_encontrados produto(s) encontrado(s)",'flash_sucesso');
				}
				else $this->Session->setFlash("Nenhum produto encontrado",'flash_erro');
			}
			else {
				$this->set('num_resultados','0');
				$this->Session->setFlash("Nenhum resultado encontrado",'flash_erro');
			}
		}
	}
	
}

?>