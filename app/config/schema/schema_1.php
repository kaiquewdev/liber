<?php 
/* App schema generated on: 2011-09-17 00:01:44 : 1316228504*/
class AppSchema extends CakeSchema {
	var $name = 'App';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $categoria_produtos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $cliente_categorias = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'primary'),
		'descricao' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $clientes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'primary', 'comment' => 'Situacao:
A -> Ativo
I -> Inativo
B -> Bloqueado'),
		'data_cadastrado' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'tipo_pessoa' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 1, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nome_fantasia' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'logradouro_nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'logradouro_numero' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'logradouro_complemento' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'bairro' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cidade' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'uf' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cep' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 8, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cnpj' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 14, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'inscricao_estadual' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 12, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cpf' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 11, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rg' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'inscricao_municipal' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'numero_telefone' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'numero_celular' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'endereco_email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'observacao' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'situacao' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 1, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cliente_categoria_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'index'),
		'empresa_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'index'),
		'atualizado' => array('type' => 'timestamp', 'null' => true, 'default' => 'CURRENT_TIMESTAMP'),
		'usuario_cadastrou' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'index'),
		'usuario_alterou' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 5, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_clientes_usuarios1' => array('column' => 'usuario_cadastrou', 'unique' => 0), 'fk_clientes_usuarios2' => array('column' => 'usuario_alterou', 'unique' => 0), 'fk_clientes_empresas1' => array('column' => 'empresa_id', 'unique' => 0), 'fk_clientes_cliente_categorias1' => array('column' => 'cliente_categoria_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $contas = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'apelido' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'banco' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'agencia' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'conta' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'titular' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $empresas = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'primary'),
		'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cnpj' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 14, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'inscricao_estadual' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 12, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'telefone' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fax' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'site' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'endereco_email_principal' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'endereco_email_secundario' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'logradouro' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'numero' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'bairro' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'complemento' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cidade' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'estado' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $forma_pagamentos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'numero_maximo_parcelas' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 2),
		'numero_parcelas_sem_juros' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 2),
		'dias_intervalo_parcelamento' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 2),
		'porcentagem_juros' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'valor_taxa_fixa' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'porcentagem_desconto_a_vista' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'conta_principal' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_forma_pagamentos_contas1' => array('column' => 'conta_principal', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $fornecedor_categorias = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'primary'),
		'descricao' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $fornecedores = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'primary', 'comment' => 'Situacao:
A -> Ativo
I -> Inativo
B -> Bloqueado'),
		'data_cadastrado' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'tipo_pessoa' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 1, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nome_fantasia' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'logradouro_nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'logradouro_numero' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'logradouro_complemento' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'bairro' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cidade' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'uf' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cep' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 8, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cnpj' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 14, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'inscricao_estadual' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 12, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cpf' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 11, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rg' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'inscricao_municipal' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'numero_telefone' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'numero_celular' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'endereco_email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'observacao' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'situacao' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 1, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fornecedor_categoria_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'index'),
		'empresa_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'index'),
		'atualizado' => array('type' => 'timestamp', 'null' => true, 'default' => 'CURRENT_TIMESTAMP'),
		'usuario_cadastrou' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'index'),
		'usuario_alterou' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 5, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_fornecedores_usuarios1' => array('column' => 'usuario_cadastrou', 'unique' => 0), 'fk_fornecedores_usuarios2' => array('column' => 'usuario_alterou', 'unique' => 0), 'fk_fornecedores_empresas1' => array('column' => 'empresa_id', 'unique' => 0), 'fk_fornecedores_fornecedor_categorias1' => array('column' => 'fornecedor_categoria_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $pagar_contas = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'data_hora_cadastrada' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'eh_fiscal' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'eh_cliente_ou_fornecedor' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 1, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cliente_fornecedor_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'tipo_documento_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'numero_documento' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'valor' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'conta_origem' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'plano_conta_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'data_vencimento' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'observacao' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_contas_pagar_contas1' => array('column' => 'conta_origem', 'unique' => 0), 'fk_contas_pagar_plano_contas1' => array('column' => 'plano_conta_id', 'unique' => 0), 'fk_contas_pagar_tipo_documentos1' => array('column' => 'tipo_documento_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $pedido_venda_itens = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'pedido_venda_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'produto_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'quantidade' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'valor' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_pedido_vendas_itens_pedido_vendas1' => array('column' => 'pedido_venda_id', 'unique' => 0), 'fk_pedido_vendas_itens_produtos1' => array('column' => 'produto_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $pedido_vendas = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'data_hora_cadastrado' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'cliente_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'index'),
		'usuario_vendeu' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'index'),
		'forma_pagamento_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'data_saida' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'data_entrega' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'data_venda' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'custo_frete' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'custo_seguro' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'custo_outros' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'desconto' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'situacao' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 1, 'collate' => 'utf8_general_ci', 'comment' => 'A = Aberto
O = Orçamento
C = Cancelado
V = Vendido', 'charset' => 'utf8'),
		'usuario_alterou' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 5, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_pedido_vendas_clientes1' => array('column' => 'cliente_id', 'unique' => 0), 'fk_pedido_vendas_usuarios1' => array('column' => 'usuario_vendeu', 'unique' => 0), 'fk_pedido_vendas_forma_pagamentos1' => array('column' => 'forma_pagamento_id', 'unique' => 0), 'fk_pedido_vendas_usuarios2' => array('column' => 'usuario_alterou', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $plano_contas = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tipo' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 1, 'collate' => 'utf8_general_ci', 'comment' => 'Tipo:
D=Despesas
R=Receitas
E=Especiais', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $produto_estoque_log = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'data_hora_registro' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'produto_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'quantidade_estoque_fiscal' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'quantidade_estoque_nao_fiscal' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_log_estoque_produtos_produtos1' => array('column' => 'produto_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $produtos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'categoria_produto_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'tipo_produto' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 1, 'collate' => 'utf8_general_ci', 'comment' => 'Tipo_produto:
Para venda
Matéria-prima
Matéria-prima e venda
Produto composto', 'charset' => 'utf8'),
		'codigo_ean' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'codigo_dun' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'preco_custo' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'preco_venda' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'margem_lucro' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'tem_estoque_ilimitado' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'estoque_minimo' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'unidade' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'quantidade_estoque_fiscal' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'quantidade_estoque_nao_fiscal' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'situacao' => array('type' => 'string', 'null' => false, 'default' => 'L', 'length' => 1, 'collate' => 'utf8_general_ci', 'comment' => 'L = Em linha
F = Fora de linha', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_produtos_categoria_produtos1' => array('column' => 'categoria_produto_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $receber_contas = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'data_hora_cadastrada' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'eh_fiscal' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'eh_cliente_ou_fornecedor' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 1, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cliente_fornecedor_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'tipo_documento_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'numero_documento' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'valor' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'conta_origem' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'plano_conta_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'data_vencimento' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'observacao' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_contas_pagar_contas1' => array('column' => 'conta_origem', 'unique' => 0), 'fk_contas_pagar_plano_contas1' => array('column' => 'plano_conta_id', 'unique' => 0), 'fk_contas_pagar_tipo_documentos1' => array('column' => 'tipo_documento_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $servico_categorias = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $servico_ordem_itens = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'servico_ordem_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'servico_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'quantidade' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'valor' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_servico_ordem_itens_servicos1' => array('column' => 'servico_id', 'unique' => 0), 'fk_servico_ordem_itens_servico_ordens1' => array('column' => 'servico_ordem_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $servico_ordens = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'data_hora_cadastrada' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'cliente_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'index'),
		'usuario_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'index'),
		'forma_pagamento_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'situacao' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 1, 'collate' => 'utf8_general_ci', 'comment' => 'O = Orçamento
E = Em espera
X = Em execução
F = Finalizada
E = Entregue
C = Cancelada', 'charset' => 'utf8'),
		'dias_garantia' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 3),
		'data_hora_inicio' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'data_hora_fim' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'defeitos_relatados' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'laudo_tecnico' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'observacao' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_servico_ordens_clientes1' => array('column' => 'cliente_id', 'unique' => 0), 'fk_servico_ordens_usuarios1' => array('column' => 'usuario_id', 'unique' => 0), 'fk_servico_ordens_forma_pagamentos1' => array('column' => 'forma_pagamento_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $servicos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'servico_categoria_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'valor' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_servico_tipos_servico_categorias1' => array('column' => 'servico_categoria_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $tipo_documentos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $usuarios = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'primary'),
		'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'login' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'senha' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'permissao' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 2),
		'ativo' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tempo_criado' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'ultimo_login' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'ultimo_logout' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'usuario_UNIQUE' => array('column' => 'login', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
}
?>