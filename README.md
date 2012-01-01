#Liber
##Software livre para gestão comercial

###Sobre
Criado em php, utilizando o framework CakePHP em sua versão 1.3.

Destina-se a ser um software de fácil entendimento e utilização, por parte do usuário.

###Instalação
* Obtenha o CakePHP em: *https://github.com/cakephp/cakephp/archives/1.3*
* Faça download do Liber em: *https://github.com/tobiasgnu/liber/zipball/master*
* Extraia ambos os arquivos baixados. 
* Substitua o diretório *app* do Cakephp pelo do Liber
* Mova o diretório obitdo na extração do Cakephp para uma área acessível do seu servidor web**\***
* Certifique-se de que o diretório app/tmp tem permissoes de leitura e escrita para o usuário que executa o servidor web
* Importe o arquivo app/config/schema/dump.sql no MySQL Server
* Edite o arquivo app/config/database.php com as informações de acesso do banco de dados a ser utilizado
* Habilite o mod_rewrite, ou equivalente, no servidor web. (Instruções para [apache](http://book.cakephp.org/pt/view/917/Apache-e-mod_rewrite), [lighttp](http://book.cakephp.org/pt/view/918/Lighttpd-e-mod_magnet), [nginx](http://book.cakephp.org/pt/view/919/URLs-amig%C3%A1veis-em-nginx) e [IIS7](http://book.cakephp.org/pt/view/1636/URL-Reescrita-no-IIS7-Windows-hosts))
* Acesse o Liber utilizando seu browser preferido. Por exemplo: se os arquivos foram colocados na raiz do servidor web, na sua máquina local, acesse: http://127.0.0.1/liber
* Por padrão o usuário 'liber' vem configurado com a senha '159951', ambos sem aspas

Mais acerca da instalação, acesse: *http://book.cakephp.org/pt/view/909/Preparando-a-instala%C3%A7%C3%A3o*

**\***Nota: esta localização dos arquivos é a mais simples possível e não é recomendada para servidores de produção. Para mais informações visite: *http://book.cakephp.org/pt/view/912/Instala%C3%A7%C3%A3o*

###Contribuições/Dúvidas/Sugestões
Para sugestões e reportar erros utilize *https://github.com/tobiasgnu/liber/issues*

Contribuições podem ser efetuadas através do GitHub. Vide *http://help.github.com/fork-a-repo/*

Para outros assuntos relacionados, ou caso ache mais conveniente, envie um e-mail através do formulário *http://gnu.eti.br/blog/contato/*


