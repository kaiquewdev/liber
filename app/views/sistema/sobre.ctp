<script type="text/javascript">
	$(document).ready(function() {
		
		$('#verlicenca').click(function() {
			if ($(this).val() == 'Visualizar licença') {
				$('#licenca').show('slow');
				$(this).attr('value','Ocultar licença');
			}
			else {
				$('#licenca').hide('slow');
				$(this).attr('value','Visualizar licença');
			}
		});
		
	});
</script>

<h2 class="descricao_cabecalho">
	Sobre
</h2>

<div id="ajuda" style="margin-left: auto; margin-right: auto; text-align: center; font-size: 150%">
	<p>
		Gfreedom é um <a target="_blank" href="http://br-linux.org/faq-softwarelivre/">software livre</a>
		disponibilizado sob a Licença Pública Geral GNU (<a target="_blank" href="http://pt.wikipedia.org/wiki/GNU_General_Public_License">GPL</a>)
		criado por <a target="_blank" href="http://identi.ca/tobiassf">Tobias</a>.
		<br/>
		<br/>
		<input type="button" id="verlicenca" value="Visualizar licença" />
		<br/>
		<br/>
		<div id="licenca" name="licenca" style="display: none;">
			<p>Texto texto texto texto texto texto texto</p>
			<p>Texto texto texto texto texto texto texto</p>
			<p>Texto texto texto texto texto texto texto</p>
			<p>Texto texto texto texto texto texto texto</p>
			<p>Texto texto texto texto texto texto texto</p>
		</div>
	</p>
</div>