#!/bin/bash

cake_bin="../cake/console/cake"
app_dir="../app"

cake="$cake_bin -app $app_dir"

# crio a variavel $parametros, que contera parametros
# passados ao script
#comeco pelo segundo parametro
getv=$2
parametros=''
cont=2
# enquanto parametros nao for vazio
while [ "$getv" != "" ]; do
	parametros="$parametros ${!cont}"
	cont=$[$cont+1]
	getv=${!cont}
done

function ajuda {
	echo ""
	echo "Utilitarios de linha de comando para o cakephp."
	echo ""
	echo "-h | --help exibe este menu"
	echo "--cake [parametros] executa o console do cake com parametros"
	echo "--gerar_schema gera um arquivo de schema no diretorio app/config/schema/"
	echo "--dump_schema grava no arquivo dump_schema.sql um dump sql a partir do schema.php"
	echo "--criar_banco apaga e cria as tabelas definidas a partir do conteudo do arquivo schema.php.  "
	echo "--atalizar_schema atualiza o banco de dados conforme descrito no arquivo schema.php"
	echo ""
}

function gerar_schema {
	$cake -f schema generate
}

function dump_schema {
	$cake schema dump -write dump_schema.sql
}

function criar_banco {
	echo "CUIDADO ISTO IRA APAGAR A SUA BASE DE DADOS E CRIAR O SCHEMA!"
	echo "ENTER para continuar. Control + c para cancelar"
	read $none
	$cake schema create
}

function atualizar_schema {
	echo "ESTA FUNCAO IRA ALTERAR AS TABELAS DO BANCO DE DADOS CONFORME ESPECIFICADO NO ARQUIVO SCHEMA.PHP"
	echo "ENTER para continuar. Control + c para cancelar"
	read $none
	$cake schema run update
}


case "$1" in
	"-h"|"--help") ajuda;;
	"--cake") $cake $parametros ;;
	"--gerar_schema") gerar_schema ;;
	"--dump_schema") dump_schema;;
	"--criar_banco") criar_banco;;
	"--atualizar_schema") atualizar_schema;;
	*) ajuda;
esac

