<?php

class AppController extends Controller {
	/**
	 * Autenticação
	 */
	// Componentes utilizados por toda a aplicação
	var $components = array('Session', 'Cookie', 'Auth');
	function beforeFilter() {

		// para executar o metodo login
		$this->Auth->autoRedirect = false;
		
		// Model de usuários
		$this->Auth->userModel = 'Usuario';

		// Campos de usuário e senha
		$this->Auth->fields = array(
			'username' => 'login',
			'password' => 'senha'
		);

		// Condição de usuário ativo/válido (opcional)
		$this->Auth->userScope = array(
			'Usuario.ativo' => true
		);

		// Action da tela de login
		$this->Auth->loginAction = array(
			'controller' => 'usuarios',
			'action' => 'login'
		);

		// Action da tela após o login (com sucesso)
		// sem url de referencia
		$this->Auth->loginRedirect = array(
			'controller' => 'pages',
			'action' => 'display', 'home'
		);

		// Action para redirecionamento após o logout
		$this->Auth->logoutRedirect = array(
			'controller' => 'pages',
			'action' => 'display', 'home'
		);

		// Mensagens de erro
		$this->Auth->loginError = __('Usuário e/ou senha incorreto(s)', true);
		$this->Auth->authError = __('Você precisa fazer login para acessar esta página', true);

		/**
		 * Para permitir acesso a determinadas areas
		 * sem efetuar login
		 * 
		 * $this->Auth->allow('area1', 'area2');
		 */
		
		//Cria um novo Usuario
		/*$this->loadModel('Usuario');
		$this->Usuario->create();
		$this->Usuario->save(array(
			'nome' => 'Administrador',
			'usuario' => 'gnu9',
			'senha' => $this->Auth->password('159951'),
			'permissao' => 0,
			'ativo' => true,
			'email' => 'tobias@gnu.eti.br',
			'tempo_criado' => '2011-09-03 15:27:00'
		));*/
		
	}
	
	/**
	 * Para utilizar autocomplete
	 * http://bakery.cakephp.org/articles/gravyface/2009/07/23/how-to-add-autocomplete-to-eclipse-aptana
	 */
	
	/**
	 * -----------------------
	 * Declaração dos Model's
	 * -----------------------
	 */
	
	/**
	 * Model Cliente
	 * @var Cliente
	 */
	var $Cliente;
	
	/**
	 * --------------------------
	 * Declaração dos Componentes
	 * --------------------------
	 */
	
	/**
	 * AuthComponent
	 * @var $Auth
	 */
	var $Auth;
	
	/**
	 * Componente de Sanitização
	 * @var $Sanitizacao
	 */
	var $Sanitizacao;
	
}


?>