<?php print $html->docType()."\n"; ?>
<html>
	<head>
		<?php print $this->Html->charset()."\n"; ?>
		<title>
			<?php
			Configure::load('configuracoes');
			__(Configure::read('app.nome').': ');
			print $title_for_layout."\n";
			?>
		</title>
		<?php
			print $this->Html->meta('icon');
			print $this->Html->css('estilo.css');
			print $scripts_for_layout;
		?>
		<script src="js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/menu.superfish.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			jQuery( function() {
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
						<a href="#">Cadastrar</a>
						<ul>
							<li class="borda-primeiro">
								<?php print $html -> link('Cliente', "/clientes/cadastrar");?>
							</li>
							<li>
								<?php print $html -> link('Produto', "/produtos/cadastrar");?>
							</li>
							<li>
								<?php print $html -> link('Equipamento', "/equipamentos/cadastrar");?>
							</li>
							<li class="borda-ultimo">
								<?php print $html -> link('Usuário', "/usuarios/cadastrar");?>
							</li>
						</ul>
					</li>
			
					<li>
						<a href="#" >Consultar</a>
						<ul>
							<li class="borda-primeiro">
								<?php print $html -> link('Cliente', "/clientes/consultar");?>
							</li>
							<li>
								<?php print $html -> link('Produto', "/produtos/consultar");?>
							</li>
							<li>
								<?php print $html -> link('Equipamento', "/equipamentos/consultar");?>
							</li>
							<li class="borda-ultimo">
								<?php print $html -> link('Usuário', "/usuarios/consultar");?>
							</li>
						</ul>
					</li>
			
					<li>
						<a href="#">Documentos</a>
			
						<ul>
							<li class="borda-primeiro">
								<a href="contrato.php">Contrato</a>
							</li>
							<li>
								<a href="checklist.php">Ckeck list</a>
							</li>
							<li class="borda-ultimo">
								<a href="#">Relatórios</a>
								<ul>
									<li class="borda-primeiro borda-ultimo">
										<a href="reltecnico.php">Relatório técnico</a>
									</li>
									
								</ul>
								
							</li>
							
						</ul>
					</li>
				</ul>
			</div>
			
			&nbsp;
		</div>
		
		<div id="conteudo">
			
			<div id="flash">
				<?php print $this->Session->flash(); ?>
			</div>
			
			<?php print $content_for_layout ?>
		
			<div id="rodape">
				<?php print Configure::read('app.nome') ?> - criado por <a href="mailto:tobias@gnu.eti.br?subject=Gfreedom">Tobias</a>
			</div>
			
		</div>
		
		
		<?php echo $this->element('sql_dump'); ?>
	</body>
	
</html>
