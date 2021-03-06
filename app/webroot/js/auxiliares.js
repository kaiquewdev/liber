//document.write(unescape("%3Cscript src='js/nomedoarquivo.js' type='text/javascript'%3E%3C/script%3E"));
/*
document.write('<script type="text/javascript" src="'
    + jsFile + '"></scr' + 'ipt>'); 
*/

/*
<script type="text/javascript">
function include(file_path){
var j = document.createElement("script"); //criando um elemento script: </script><script></script>
j.type = "text/javascript"; // informando o type como text/javacript: <script type="text/javascript"></script>
j.src = file_path; // Inserindo um src com o valor do parâmetro file_path: <script type="javascript" src="+file_path+"></script>
document.body.appendChild(j); // Inserindo o seu elemento(no caso o j) como filho(child) do  BODY: <html><body><script type="javascript" src="+file_path+"></script></body></html>
}

//incluindo um arquivo com a função include()
include("arquivo.js");

function include_once(file_path) {
var sc = document.getElementsByTagName("script");
for (var x in sc)
if (sc[x].src != null &amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp; sc[x].src.indexOf(file_path) != -1) return;
include(file_path);
}
//incluindo um arquivo com a função include_once()
include_once("arquivo.js");
 */
function submissaoFormulario(objeto) {
	$(function() {
		var $dialogo = $('<div title="Enviar"><p>Deseja enviar os dados?</p></div>');
		
		$dialogo.dialog({
				resizable: true,
				autoOpen: true,
				modal: true,
				buttons: {
					'Sim': function() {
						$(this).dialog( "close" );
						document.forms[objeto.id].submit();
					},
					'Não': function() {
						$(this).dialog( "close" );
					}
				}
			});
	});
}

function dialogoDeletar(objeto) {
	// #FIXME tá bugado, simular o click
	$(function() {
		var $dialogo = $('<div title="Excluir" style="display:none"><p><span class="ui-icon ui-icon-alert"'+
		'style="float:left; margin:0 7px 20px 0;"></span>'+
		'Deseja excluir o registro?</p></div>');
		$dialogo.dialog({
				resizable: true,
				autoOpen: true,
				modal: true,
				buttons: {
					'Sim': function() {
						$(this).dialog( "close" );
						
						$('.'+c).trigger('click');
					},
					'Não': function() {
						$(this).dialog( "close" );
					}
				}
			});
	});
}

/**
 * formata uma $number com precisao de $decimals casas decimais
 * utilizando $dec_point como separador decimal e $thousands_sep
 * como separador de milhar
 * @return $number formatado
 */
function number_format (number, decimals, dec_point, thousands_sep) {
	//http://phpjs.org/functions/number_format:481
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

/**
 * Retorna x arredondado para n casas
 * @param x variavel float
 * @param n numero de casas decimais
 */
function arredonda_float(x,n){
	if ((n != null) && (n != '')) {
		if(!parseInt(n))
  			var n=0;
	}
	else n = 2;
	if(!parseFloat(x))
		return x;
	return Math.round(x*Math.pow(10,n))/Math.pow(10,n);
}

/**
 * converte uma string no formato 5.123,34 para um numero (int ou float)
 * que possa ser utilizado em calculos
 */
function moeda2numero (variavel) {
	/*variavel = variavel.replace('.','');
	variavel = variavel.replace(',','.');
	variavel = parseFloat (variavel);
	return variavel;*/
	variavel = (variavel.replace(/\./g,'')).replace(/,/g,'.');
	return number_format(variavel,2,'.','');
}

/**
 * converte uma variavel int ou float para a representação brasileira
 * de moeda
 */
function numero2moeda (variavel) {
	/*if (variavel != null && variavel != '') {
		variavel = variavel + ''; //converte para string
		return variavel.replace('.',',');
	}*/
	return number_format(variavel,2,',','.');
}

/**
 * Retorna true se variavel é numero inteiro,
 * false caso contrario
 */
function eh_inteiro(variavel) {
	if((parseFloat(variavel) == parseInt(variavel)) && !isNaN(variavel)){
		return true;
	} else {
		return false;
	}
}

$(function() {
	
	/*
	$('a[title="Excluir"]').click(function(evento) {
		evento.preventDefault();
		dialogoDeletar($(this));
		
	});
	*/
	
	/**
	 * Enter emulando TAB
	 */
	/*textboxes = $("input, select, textarea");
	if ($.browser.mozilla) {
		$(textboxes).keypress (checkForEnter);
	} else {
		$(textboxes).keydown (checkForEnter);
	}
	function checkForEnter (event) {
		if (event.keyCode == 13) {
			currentBoxNumber = textboxes.index(this);
			if (textboxes[currentBoxNumber + 1] != null) {
				nextBox = textboxes[currentBoxNumber + 1]
				nextBox.focus();
				event.preventDefault();
				return false;
			}
		}
	}*/

});

/*
	Masked Input plugin for jQuery
	Copyright (c) 2007-2011 Josh Bush (digitalbush.com)
	Licensed under the MIT license (http://digitalbush.com/projects/masked-input-plugin/#license) 
	Version: 1.3
*/
(function(a){var b=(a.browser.msie?"paste":"input")+".mask",c=window.orientation!=undefined;a.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},dataName:"rawMaskFn"},a.fn.extend({caret:function(a,b){if(this.length!=0){if(typeof a=="number"){b=typeof b=="number"?b:a;return this.each(function(){if(this.setSelectionRange)this.setSelectionRange(a,b);else if(this.createTextRange){var c=this.createTextRange();c.collapse(!0),c.moveEnd("character",b),c.moveStart("character",a),c.select()}})}if(this[0].setSelectionRange)a=this[0].selectionStart,b=this[0].selectionEnd;else if(document.selection&&document.selection.createRange){var c=document.selection.createRange();a=0-c.duplicate().moveStart("character",-1e5),b=a+c.text.length}return{begin:a,end:b}}},unmask:function(){return this.trigger("unmask")},mask:function(d,e){if(!d&&this.length>0){var f=a(this[0]);return f.data(a.mask.dataName)()}e=a.extend({placeholder:"_",completed:null},e);var g=a.mask.definitions,h=[],i=d.length,j=null,k=d.length;a.each(d.split(""),function(a,b){b=="?"?(k--,i=a):g[b]?(h.push(new RegExp(g[b])),j==null&&(j=h.length-1)):h.push(null)});return this.trigger("unmask").each(function(){function v(a){var b=f.val(),c=-1;for(var d=0,g=0;d<k;d++)if(h[d]){l[d]=e.placeholder;while(g++<b.length){var m=b.charAt(g-1);if(h[d].test(m)){l[d]=m,c=d;break}}if(g>b.length)break}else l[d]==b.charAt(g)&&d!=i&&(g++,c=d);if(!a&&c+1<i)f.val(""),t(0,k);else if(a||c+1>=i)u(),a||f.val(f.val().substring(0,c+1));return i?d:j}function u(){return f.val(l.join("")).val()}function t(a,b){for(var c=a;c<b&&c<k;c++)h[c]&&(l[c]=e.placeholder)}function s(a){var b=a.which,c=f.caret();if(a.ctrlKey||a.altKey||a.metaKey||b<32)return!0;if(b){c.end-c.begin!=0&&(t(c.begin,c.end),p(c.begin,c.end-1));var d=n(c.begin-1);if(d<k){var g=String.fromCharCode(b);if(h[d].test(g)){q(d),l[d]=g,u();var i=n(d);f.caret(i),e.completed&&i>=k&&e.completed.call(f)}}return!1}}function r(a){var b=a.which;if(b==8||b==46||c&&b==127){var d=f.caret(),e=d.begin,g=d.end;g-e==0&&(e=b!=46?o(e):g=n(e-1),g=b==46?n(g):g),t(e,g),p(e,g-1);return!1}if(b==27){f.val(m),f.caret(0,v());return!1}}function q(a){for(var b=a,c=e.placeholder;b<k;b++)if(h[b]){var d=n(b),f=l[b];l[b]=c;if(d<k&&h[d].test(f))c=f;else break}}function p(a,b){if(!(a<0)){for(var c=a,d=n(b);c<k;c++)if(h[c]){if(d<k&&h[c].test(l[d]))l[c]=l[d],l[d]=e.placeholder;else break;d=n(d)}u(),f.caret(Math.max(j,a))}}function o(a){while(--a>=0&&!h[a]);return a}function n(a){while(++a<=k&&!h[a]);return a}var f=a(this),l=a.map(d.split(""),function(a,b){if(a!="?")return g[a]?e.placeholder:a}),m=f.val();f.data(a.mask.dataName,function(){return a.map(l,function(a,b){return h[b]&&a!=e.placeholder?a:null}).join("")}),f.attr("readonly")||f.one("unmask",function(){f.unbind(".mask").removeData(a.mask.dataName)}).bind("focus.mask",function(){m=f.val();var b=v();u();var c=function(){b==d.length?f.caret(0,b):f.caret(b)};(a.browser.msie?c:function(){setTimeout(c,0)})()}).bind("blur.mask",function(){v(),f.val()!=m&&f.change()}).bind("keydown.mask",r).bind("keypress.mask",s).bind(b,function(){setTimeout(function(){f.caret(v(!0))},0)}),v()})}})})(jQuery)
jQuery(function($){
	$(".mascara_data").mask("99/99/9999"); //data
	$('.mascara_hora').mask('99:99'); //hora
	$(".mascara_datahora").mask("99/99/9999 99:99"); //data hora
	$('.mascara_fone').mask('(99) 999-9999'); //telefone
	$('.mascara_rg').mask('99.999.999-9'); //RG
	$('.mascara_agencia').mask('9999-9'); //Agência
	$('.mascara_conta').mask('9.999-9'); //Conta
});