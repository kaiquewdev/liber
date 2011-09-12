//document.write(unescape("%3Cscript src='js/nomedoarquivo.js' type='text/javascript'%3E%3C/script%3E"));

$(document).ready(function() {
	
	//para todos os botoes de submissao de formualario
	$('.submit input[type="submit"]').click(function() {
		return confirm("Confirma o envio dos dados?");
	});
	
	
});
