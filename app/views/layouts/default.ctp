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
			print $scripts_for_layout;
		?>
		<script src="<?php print $html->url('/', true )?>js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php print $html->url('/', true )?>js/menu.superfish.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php print $html->url('/', true )?>js/jquery-ui.js" type="text/javascript" charset="utf-8"></script>
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
								<a href="#">Cadastrar</a>
								<ul>
									<li><?php print $html -> link('Fornecedor', "/fornecedores/cadastrar");?></li>
									<li><?php print $html -> link('Produto', "/produtos/cadastrar");?></li>
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
						<a href="#">Vendas</a>
						<ul>
							<li>
								<a href="#">Cadastrar</a>
								<ul>
									<li><?php print $html -> link('Cliente', "/clientes/cadastrar");?></li>
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
							<li><?php print $html -> link('Formas de pagamento', "/formaPagamentos");?></li>
						</ul>
					</li>
			
					<li>
						<a href="#" >Financeiro</a>
						<ul>
							<li>
								<?php print $html -> link('Contas a receber', "/contasreceber/");?>
							</li>
							<li>
								<?php print $html -> link('Contas a pagar', "/contaspagar/");?>
							</li>
							<li class="separador">
								<?php print $html -> link('Plano de contas', "/planocontas/");?>
							</li>
							<li>
								<?php print $html -> link('Contas', "/contas/");?>
							</li>
						</ul>
					</li>
			
					<li>
						<a href="#">Sistema</a>
			
						<ul>
							<li>
								<?php print $html -> link('Usuários', "/usuarios/");?>
							</li>
							<li>
								<?php print $html -> link('Ajuda', "/sistema/ajuda");?>
							</li>
							<li>
								<?php print $html -> link('Sobre', "/sistema/sobre");?>
							</li>
							<li>
								<?php print $html -> link('Sair', "/usuarios/logout");?>
							</li>
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
