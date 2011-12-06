<?php print $html->docType()."\n"; ?>
<html>
	<head>
		<?php print $this->Html->charset()."\n"; ?>
		<title>
			Liber - login
		</title>
		<?php
			print $this->Html->meta('icon');
			print $this->Html->css('login.css');
			print $scripts_for_layout;
			print $this->Html->script('jquery');
		?>
		
		<script type="text/javascript">
			$(document).ready(function() {
				if ($('#UsuarioLogin').val() == undefined || $('#UsuarioLogin').val() == "") {
					$('#UsuarioLogin').focus();
				}
				else {
					$('#UsuarioSenha').focus();
				}
			});
		</script>
	</head>
	
	<body>
		
		
		<div id="cabecalho">
			
		</div>
		
		<div id="banner">
			&nbsp;
		</div>
		
		<div id="conteudo">
			
			<div id="flash">
				<?php print $this->Session->flash(); ?>
				
			</div>
			
			<?php print $content_for_layout ?>
		
			<div id="rodape">
				
			</div>
			
		</div>
		
	</body>
	
</html>