<?php print $html->docType()."\n"; ?>
<html>
	<head>
		<?php print $this->Html->charset()."\n"; ?>
		<title>
			<?php
			Configure::load('configuracoes');
			__(Configure::read('app.nome').' - ');
			print $title_for_layout."\n";
			?>
		</title>
		<?php
			print $this->Html->meta('icon');
			print $this->Html->css('estilo.css');
			print $this->Html->css('jquery-ui/jquery-ui.css');
		?>
		<script src="<?php print $html->url('/', true )?>js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php print $html->url('/', true )?>js/menu.superfish.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php print $html->url('/', true )?>js/jquery-ui.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php print $html->url('/', true )?>js/auxiliares.js" type="text/javascript" charset="utf-8"></script>
		<?php print $scripts_for_layout;?>
		<script type="text/javascript">
			$( function() {
				$('ul.sf-menu').superfish();
			});
		</script>
	</head>
	
	<body>
		
		<div id="cabecalho">
			&nbsp;
			<div id="menu" name="menu">
				<ul class="sf-menu">
					<li class="current borda-primeiro borda-ultimo">
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
									<li><?php print $html -> link('Listar todos', "/fornecedores/");?></li>
								</ul>
							</li>
							<li>
								<li><?php print $html -> link('Produtos', "/produtos/");?></li>
								<ul>
									<li><?php print $html -> link('Cadastrar', "/produtos/cadastrar");?></li>
									<li><?php print $html -> link('Pesquisar', "/produtos/pesquisar");?></li>
									<li><?php print $html -> link('Listar todos', "/produtos/");?></li>
								</ul>
							</li>
							<li>
								<a href="#">Relatórios</a>
								<ul>
									<li><?php print $html -> link('Fornecedores cadastrados', "/relatorios/fornecedoresCadastrados");?></li>
									<li><a href="#">XXXX</a></li>
									<li><a href="#">XXXX</a></li>
								</ul>
							</li>
							<li><a href="#">XXXX</a></li>
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
									<li><?php print $html -> link('Listar todos', "/clientes/");?></li>
								</ul>
							</li>
							<li>
								<a href="#">Relatórios</a>
								<ul>
									<li><a href="#">XXXX</a></li>
									<li><a href="#">XXXX</a></li>
									<li><a href="#">XXXX</a></li>
								</ul>
							</li>
							<li><a href="#">XXXX</a></li>
						</ul>
					</li>
			
					<li>
						<a href="#" >Financeiro</a>
						<ul>
							<li><?php print $html -> link('Contas a receber', "/receberContas/");?></li>
							<li><?php print $html -> link('Contas a pagar', "/pagarContas/");?></li>
							<li><?php print $html -> link('Plano de contas', "/planoContas/");?></li>
							<li class="separador"><?php print $html -> link('Tipo de documentos', "/tipoDocumentos/");?></li>
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
									<li><?php print $html -> link('Listar todas', "/empresas/");?></li>
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
		
		
		<?php echo $this->element('sql_dump'); ?>
	</body>
	
</html>
