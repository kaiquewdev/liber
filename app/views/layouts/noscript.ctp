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
		?>
	</head>
	
	<body>
		
		<div id="cabecalho">
			<div id="menu" name="menu">
				<ul class="sf-menu">
					<li>
						<?php print $html -> link('Início', "/");?>
					</li>
					
				</ul>
			</div>
			
			<div id="banner">
				<div class="logo">Liber</div>
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
				
			</div>
			
		</div>

	</body>
	
</html>
