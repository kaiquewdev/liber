<?php print $html->docType()."\n"; ?>
<html>
	<head>
		<?php print $this->Html->charset()."\n"; ?>
		<noscript>
			<meta http-equiv="refresh" content="0; URL=<?php print $this->Html->url('/',true); ?>sistema/noscript" />
		</noscript>
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
			print $this->Html->script('auxiliares.js');
		?>
	</head>
	
	<body>
		
		<div id="cabecalho">
			<div id="menu" name="menu">
				<?php print $this->element('menu'); ?>
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
		
		<?php 
		print $this->Html->script('menu.superfish.js');
		print $this->Html->script('jquery-ui.js');
		print $scripts_for_layout;
		?>
		<script type="text/javascript">
			$( function() {
				$('ul.sf-menu').superfish();
			});
		</script>
		
		<?php
		print $this->element('sql_dump');
		//#TODO no cakebook diz que é preciso usar isto, verificar
		// http://book.cakephp.org/pt/view/1594/Usando-uma-biblioteca-de-Javascript-espec%C3%ADfica
		//$js->writeBuffer(); // Escreve o conteudo em cache dos scripts
		?>
	</body>
	
</html>
