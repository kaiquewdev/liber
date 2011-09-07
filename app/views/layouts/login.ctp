<?php print $html->docType()."\n"; ?>
<html>
	<head>
		<?php print $this->Html->charset()."\n"; ?>
		<title>
			Gfreedom - login
		</title>
		<?php
			print $this->Html->meta('icon');
			print $this->Html->css('login.css');
			print $scripts_for_layout;
		?>
		<script src="<?php print $html->url('/', true )?>js/jquery.js" type="text/javascript" charset="utf-8"></script>
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
			<div id="banner">
				&nbsp;
			</div>
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