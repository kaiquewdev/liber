<?php print $html->docType()."\n"; ?>
<html>
	<head>
		<?php print $this->Html->charset()."\n"; ?>
		<title>
			<?php
			__('Liber - ');
			print $title_for_layout."\n";
			?>
		</title>
		<?php
			print $this->Html->meta('icon');
			print $this->Html->css('estilo.css');
			print $this->Html->css('jquery-ui/jquery-ui.css');
			print $this->Html->script('jquery');
		?>
	</head>
	
	<body>
		
		<div id="cabecalho">
			&nbsp;
			<div id="menu" name="menu">
				<ul class="sf-menu">
					<li>
						<?php print $html -> link('Início', "/");?>
					</li>
					
					<li>
						<a href="#">Compras</a>
						<ul>
							<li>
								<?php print $html -> link('Fornecedores', "/fornecedores");?>
								<ul>
									<li><?php print $html -> link('Cadastrar', "/fornecedores/cadastrar");?></li>
									<li><?php print $html -> link('Pesquisar', "/fornecedores/pesquisar");?></li>
									<li><?php print $html -> link('Listar', "/fornecedores/");?></li>
									<li>
										<?php print $html -> link('Categorias', "/fornecedorCategorias");?>
										<ul>
											<li><?php print $html -> link('Cadastrar', "/fornecedorCategorias/cadastrar");?></li>
											<li><?php print $html -> link('Listar', "/fornecedorCategorias");?></li>
										</ul>
									</li>
								</ul>
							</li>
							<li>
								<?php print $html -> link('Produtos', "/produtos/");?>
								<ul>
									<li><?php print $html -> link('Cadastrar', "/produtos/cadastrar");?></li>
									<li><?php print $html -> link('Pesquisar', "/produtos/pesquisar");?></li>
									<li><?php print $html -> link('Listar', "/produtos/");?></li>
									<li>
										<?php print $html -> link('Categorias', "/categoriaProdutos");?>
										<ul>
											<li><?php print $html -> link('Cadastrar', "/categoriaProdutos/cadastrar");?></li>
											<li><?php print $html -> link('Listar', "/categoriaProdutos");?></li>
										</ul>
									</li>
								</ul>
							</li>
							<li>
								<?php print $html -> link('Pedido de compra', "/pedidoCompras");?>
								<ul>
									<li><?php print $html -> link('Cadastrar', "/pedidoCompras/cadastrar");?></li>
									<li><?php print $html -> link('Pesquisar', "/pedidoCompras/pesquisar");?></li>
									<li><?php print $html -> link('Listar', "/pedidoCompras/");?></li>
								</ul>
							</li>
							<li>
								<a href="#">Relatórios</a>
								<ul>
									<li><?php print $html -> link('Fornecedores cadastrados', "/relatorios/fornecedoresCadastrados");?></li>
								</ul>
							</li>
						</ul>
					</li>
					
					<li>
						<a href="#">Vendas</a>
						<ul>
							<li>
								<?php print $html -> link('Clientes', "/clientes");?>
								<ul>
									<li><?php print $html -> link('Cadastrar', "/clientes/cadastrar");?></li>
									<li><?php print $html -> link('Pesquisar', "/clientes/pesquisar");?></li>
									<li><?php print $html -> link('Listar', "/clientes/");?></li>
									<li>
										<?php print $html -> link('Categorias', "/clienteCategorias");?>
										<ul>
											<li><?php print $html -> link('Cadastrar', "/clienteCategorias/cadastrar");?></li>
											<li><?php print $html -> link('Listar', "/clienteCategorias");?></li>
										</ul>
									</li>
								</ul>
							</li>
							<li>
								<?php print $html -> link('Pedido de venda', "/pedidoVendas");?>
								<ul>
									<li><?php print $html -> link('Cadastrar', "/pedidoVendas/cadastrar");?></li>
									<li><?php print $html -> link('Pesquisar', "/pedidoVendas/pesquisar");?></li>
									<li><?php print $html -> link('Listar', "/pedidoVendas/");?></li>
								</ul>
							</li>
							<li>
								<a href="#">Relatórios</a>
								<ul>
									<li><?php print $html -> link('ABC de vendas', "/relatorios/abcvendas");?></li>
								</ul>
							</li>
						</ul>
					</li>
					
					<li>
						<a href="#">Serviços</a>
						<ul>
							<li>
								<?php print $html -> link('Ordens de serviço', "/servicoOrdens");?>
								<ul>
									<li><?php print $html -> link('Cadastrar', "/servicoOrdens/cadastrar");?></li>
									<li><?php print $html -> link('Pesquisar', "/servicoOrdens/pesquisar");?></li>
									<li><?php print $html -> link('Listar', "/servicoOrdens");?></li>
								</ul>
							</li>
							<li><?php print $html -> link('Serviços', "/servicos/");?></li>
							<li><?php print $html -> link('Categorias de serviços', "/servicoCategorias");?></li>
						</ul>
					</li>
			
					<li>
						<a href="#" >Financeiro</a>
						<ul>
							<li>
								<?php print $html -> link('Contas a receber', "/receberContas/");?>
								<ul>
									<li><?php print $html -> link('Cadastrar', "/receberContas/cadastrar");?></li>
									<li><?php print $html -> link('Pesquisar', "/receberContas/pesquisar");?></li>
									<li><?php print $html -> link('Listar', "/receberContas/");?></li>
								</ul>
							</li>
							<li>
								<?php print $html -> link('Contas a pagar', "/pagarContas/");?>
								<ul>
									<li><?php print $html -> link('Cadastrar', "/pagarContas/cadastrar");?></li>
									<li><?php print $html -> link('Pesquisar', "/pagarContas/pesquisar");?></li>
									<li><?php print $html -> link('Listar', "/pagarContas/");?></li>
								</ul>
							</li>
							<li><?php print $html -> link('Plano de contas', "/planoContas/");?></li>
							<li><?php print $html -> link('Tipo de documentos', "/tipoDocumentos/");?></li>
							<li class="separador"></li>
							<li><?php print $html -> link('Formas de pagamento', "/formaPagamentos");?></li>
							<li><?php print $html -> link('Contas', "/contas/");?></li>
						</ul>
					</li>
			
					<li>
						<a href="#">Outros</a>
						<ul>
							<li>
								<?php print $html -> link('Empresas', "/empresas");?>
								<ul>
									<li><?php print $html -> link('Cadastrar', "/empresas/cadastrar");?></li>
									<li><?php print $html -> link('Listar', "/empresas/");?></li>
								</ul>
							</li>
							<li><?php print $html -> link('Usuários', "/usuarios/");?></li>
							<li><?php print $html -> link('Ajuda', "/sistema/ajuda");?></li>
							<li><?php print $html -> link('Sobre', "/sistema/sobre");?></li>
							<li><?php print $html -> link('Sair', "/usuarios/logout");?></li>
						</ul>
					</li>
				</ul>
			</div>
			
			<div id="banner">
				<div class="logo">Gfreedom</div>
			</div>
		</div>
		
		<div id="conteudo">
			
			<div id="flash">
				<?php
				print $this->Session->flash();
				print $this->Session->flash('auth');
				?>
			</div>
			
			<?php print $content_for_layout ?>
		
			<div id="rodape">
				<?php print Configure::read('app.nome') ?> - criado por <a href="mailto:tobias@gnu.eti.br?subject=Gfreedom">Tobias</a>
			</div>
			
		</div>
		
		<?php 
		print $this->Html->script('menu.superfish.js');
		print $this->Html->script('jquery-ui.js');
		print $this->Html->script('auxiliares.js');
		print $scripts_for_layout;
		?>
		<script type="text/javascript">
			$( function() {
				$('ul.sf-menu').superfish();
			});
		</script>
		
		<?php
		print $this->element('sql_dump');
		$js->writeBuffer(); // Escreve o conteudo em cache dos scripts
		?>
	</body>
	
</html>
