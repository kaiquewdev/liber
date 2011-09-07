<?php

class UsuariosController extends AppController {
	var $name = "Usuarios";
	var $components = array('Auth');
	
	function login() {
		$this->layout = 'login';
		if ($this->Auth->user()) {
			$this->Usuario->id = $this->Auth->user('id');
			$h = array('ultimo_login'=>date('Y-m-d H:i:s'));
			$this->Usuario->save($h);
			/* no app_controller desabilitei o redirecionamento automatico
			 * para que o metodo login fosse executado, redireciono aqui
			 */
			$this->redirect($this->Auth->redirect());
		}
	}
	
	function logout() {
		if ($this->Auth->user()) {
			$this->Usuario->id = $this->Auth->user('id');
			$h = array('ultimo_logout'=>date('Y-m-d H:i:s'));
			$this->Usuario->save($h);
		}
		$this->layout = 'login';
		// Redireciona o usuário para o action do logoutRedirect
		 $this->redirect($this->Auth->logout());
	}
	
	function index() {
		$dados = $this->paginate('Usuario');
		$this->set('consulta_usuario',$dados);
	}
	
	function cadastrar() {
		if (! empty($this->data)) {
			if ($this->data['Usuario']['senha'] == $this->Auth->password($this->data['Usuario']['senha_confirma'])) {
				$this->Usuario->create();
				if ($this->Usuario->save($this->data)) {
					$this->Session->setFlash('Usuário cadastrado com sucesso.');
					$this->redirect(array('action'=>'index'));
				}
				else {
					$this->data['Usuario']['senha'] = NULL;
					$this->data['Usuario']['senha_confirma'] = NULL;
					$this->Session->setFlash('Erro ao cadastrar o usuário.');
				}
			}
			else {
				$this->data['Usuario']['senha'] = NULL;
				$this->data['Usuario']['senha_confirma'] = NULL;
				$this->Session->setFlash('As senhas digitadas não conferem.');
			}
		}
	}
	
	function editar($id = null) {
		$this->Usuario->id = $id;
		//popular o formulario, na primeira carga
		if (empty ($this->data)) {
			$this->data = $this->Usuario->read();
			// formulario carrega sem as senhas
			unset($this->data['Usuario']['senha']);
			unset($this->data['Usuario']['senha_confirma']);
			if ( ! $this->data) {
				$this->Session->setFlash('Usuário não encontrado.');
				$this->redirect(array('action'=>'index'));
			}
		}
		//formulario ja estava populado
		else {
			if ($this->data['Usuario']['senha'] == $this->Auth->password($this->data['Usuario']['senha_confirma'])) {
				/**
				 * caso a senha não seja informada, pego a antiga
				 * nota: o campo senha sempre terá valor, pois é feito hash do que havia nele
				 * por isso vejo se a segunda senha informada está em branco
				 */
				if (empty($this->data['Usuario']['senha_confirma'])) {
					$old = $this->Usuario->read();
					$this->data['Usuario']['senha'] = $old['Usuario']['senha'];
					$this->data['Usuario']['senha_confirma'] = $old['Usuario']['senha'];
				}
				if ($this->Usuario->save($this->data)) {
					$this->Session->setFlash('Usuário alterado com sucesso.');
					$this->redirect(array('action'=>'index'));
				}
				else {
					$this->data['Usuario']['senha'] = NULL;
					$this->data['Usuario']['senha_confirma'] = NULL;
					$this->Session->setFlash('Erro ao atualizar o usuário.');
				}
			}
			else {
				$this->data['Usuario']['senha'] = NULL;
				$this->data['Usuario']['senha_confirma'] = NULL;
				$this->Session->setFlash('As senhas digitadas não conferem.');
			}
		}
	}
	
	function excluir($id=NULL) {
		if (! empty($id)) {
			if ($id == 1) {
				$this->Session->setFlash("O usuário administrador não pode ser excluído.");
				$this->redirect(array('action'=>'index'));
			}
			else {
				if ($this->Usuario->delete($id)) $this->Session->setFlash("Usuário $id excluído com sucesso.");
				else $this->Session->setFlash("Usuário $id não pode ser excluído.");
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->Session->setFlash('Usuário não informado.');
		}
	}
	
	
}

?>